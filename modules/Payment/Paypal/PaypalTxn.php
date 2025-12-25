<?php

namespace Payment\Paypal;

use App\Jobs\WithdrawUpdateJob;
use App\Models\Order;
use App\Services\OrderService;
use App\Traits\NotifyTrait;
use Payment\Transaction\BaseTxn;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalTxn extends BaseTxn
{
    use NotifyTrait;

    protected $toEmail;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $fieldData = json_decode($txnInfo->manual_field_data, true);
        $this->toEmail = $fieldData['paypal_email']['value'] ?? '';
    }

    public function withdraw()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $data = [
            'sender_batch_header' => [
                'sender_batch_id' => $this->txn,
                'email_subject' => '',
                'email_message' => '',
            ],
            'items' => [
                0 => [
                    'recipient_type' => 'EMAIL',
                    'amount' => [
                        'value' => $this->amount,
                        'currency' => $this->currency,
                    ],
                    'note' => 'Thanks for your patronage!',
                    'sender_item_id' => $this->txn,
                    'receiver' => $this->toEmail,
                    'alternate_notification_method' => [
                        'phone' => [
                            'country_code' => '91',
                            'national_number' => '9999988888',
                        ],
                    ],
                    'notification_language' => 'fr-FR',
                ],
            ],
        ];
        $response = $provider->createBatchPayout($data);

        $data = [
            'payout_batch_id' => $response['batch_header']['payout_batch_id'],
            'tnx' => $this->txn,
        ];

        WithdrawUpdateJob::dispatch('paypal', (object) $data);

        return $data;
    }

    public function deposit()
    {
        try {
            // Validate PayPal credentials before proceeding
            $paypalConfig = config('paypal');
            $mode = $paypalConfig['mode'] ?? 'live';
            $credentials = $paypalConfig[$mode] ?? [];
            
            // Log configuration for debugging (without exposing secrets)
            \Log::info('PayPal Payment Attempt', [
                'mode' => $mode,
                'has_client_id' => !empty($credentials['client_id']),
                'has_client_secret' => !empty($credentials['client_secret']),
                'txn' => $this->txn,
            ]);
            
            // Check for required credentials (App ID is NOT required - it's auto-set)
            if (empty($credentials['client_id']) || empty($credentials['client_secret'])) {
                \Log::error('PayPal credentials missing', [
                    'mode' => $mode,
                    'client_id_empty' => empty($credentials['client_id']),
                    'client_secret_empty' => empty($credentials['client_secret']),
                ]);
                
                if ($this->order) {
                    app(OrderService::class)->setOrderFailed($this->order);
                } elseif (session('order_id')) {
                    $order = Order::find(session('order_id'));
                    if ($order) {
                        app(OrderService::class)->setOrderFailed($order);
                    }
                }
                
                notify()->error(__('PayPal is not properly configured. Missing Client ID or Client Secret. Please contact support.'));
                return redirect()->route('checkout');
            }
            
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            \Log::info('PayPal creating order', [
                'currency' => $this->currency,
                'amount' => $this->amount,
                'amount_rounded' => number_format((float)$this->amount, 2, '.', ''),
                'txn' => $this->txn,
            ]);

            $response = $provider->createOrder([
                'intent' => 'CAPTURE',
                'application_context' => [
                    'return_url' => route('ipn.paypal'),
                    'cancel_url' => route('status.cancel'),
                ],
                'purchase_units' => [
                    0 => [
                        'amount' => [
                            'currency_code' => $this->currency,
                            'value' => number_format((float)$this->amount, 2, '.', ''), // PayPal requires max 2 decimal places
                        ],
                        'reference_id' => $this->txn,
                    ],
                ],
            ]);

            \Log::info('PayPal createOrder response', [
                'has_id' => isset($response['id']),
                'has_links' => isset($response['links']),
                'status' => $response['status'] ?? 'no_status',
                'response_keys' => array_keys($response ?? []),
            ]);

            if (isset($response['id']) && $response['id'] != null && isset($response['links']) && is_array($response['links'])) {
                foreach ($response['links'] as $links) {
                    if (($links['rel'] ?? null) === 'approve' && ! empty($links['href'])) {
                        \Log::info('PayPal redirect URL found', ['url' => $links['href']]);
                        
                        if ($this->order) {
                            app(OrderService::class)->setTrnxId($this->order, $response['id']);
                        } elseif (session('order_id')) {
                            app(OrderService::class)->setTrnxId(Order::find(session('order_id')), $response['id']);
                        }

                        return redirect()->away($links['href']);
                    }
                }
            }

            \Log::error('PayPal payment could not be initiated - no approval link', [
                'response' => $response,
            ]);

            if ($this->order) {
                app(OrderService::class)->setOrderFailed($this->order);
            }

            notify()->error(__($response['message'] ?? 'PayPal payment could not be initiated.'));

            return redirect()->route('checkout');
        } catch (\Throwable $e) {
            \Log::error('PayPal payment exception', [
                'error' => $e->getMessage(),
                'txn' => $this->txn,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            
            if ($this->order) {
                app(OrderService::class)->setOrderFailed($this->order);
            } elseif (session('order_id')) {
                $order = Order::find(session('order_id'));
                if ($order) {
                    app(OrderService::class)->setOrderFailed($order);
                }
            }

            notify()->error(__('PayPal payment failed: ' . $e->getMessage()));

            return redirect()->route('checkout');
        }

    }
}
