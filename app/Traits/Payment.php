<?php

namespace App\Traits;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Facades\Txn\Txn;
use App\Models\DepositMethod;
use App\Models\Gateway;
use App\Models\Order;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use App\Services\OrderService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Payment\Binance\BinanceTxn;
use Payment\Blockchain\BlockchainTxn;
use Payment\BlockIo\BlockIoTxn;
use Payment\Btcpayserver\BtcpayserverTxn;
use Payment\Cashmaal\CashmaalTxn;
use Payment\Coinbase\CoinbaseTxn;
use Payment\Coingate\CoingateTxn;
use Payment\Coinpayments\CoinpaymentsTxn;
use Payment\Coinremitter\CoinremitterTxn;
use Payment\Cryptomus\CryptomusTxn;
use Payment\Flutterwave\FlutterwaveTxn;
use Payment\Instamojo\InstamojoTxn;
use Payment\Mollie\MollieTxn;
use Payment\Monnify\MonnifyTxn;
use Payment\Nowpayments\NowpaymentsTxn;
use Payment\Paymongo\PaymongoTxn;
use Payment\Paypal\PaypalTxn;
use Payment\Paytm\PaytmTxn;
use Payment\Perfectmoney\PerfectmoneyTxn;
use Payment\Razorpay\RazorpayTxn;
use Payment\Securionpay\SecurionpayTxn;
use Payment\Stripe\StripeTxn;
use Payment\Twocheckout\TwocheckoutTxn;

trait Payment
{
    use NotifyTrait;
    use PlanTrait;

    protected function depositAutoGateway($gateway, $txnInfo)
    {
        $txn = $txnInfo->tnx;
        Session::put('deposit_tnx', $txn);

        $depositMethod = DepositMethod::code($gateway)->with('gateway')->first();
        $gateway = strtolower($depositMethod?->gateway?->gateway_code ?? $gateway ?? 'none');

        $gatewayTxn = self::gatewayMap($gateway, $txnInfo);
        if ($gatewayTxn) {
            return $gatewayTxn->deposit();
        }

        $order = $txnInfo->order ?? Order::find(session('order_id') ?? $txnInfo->order_id);
        if ($order) {
            orderService()->setOrderFailed($order);
        } else {
            app(OrderService::class)->dismissSession();
        }

        notify()->error(__('Selected payment gateway is unavailable. Please try again.'));

        return to_buyerSellerRoute('dashboard');
    }

    protected function withdrawAutoGateway($gatewayCode, $txnInfo)
    {
        $gatewayTxn = self::gatewayMap($gatewayCode, $txnInfo);
        if ($gatewayTxn && config('app.demo') == 0) {
            $gatewayTxn->withdraw();
        }

        return to_route('user.payment.index');
    }

    protected function paymentNotify($tnx, $status)
    {
        $tnxInfo = Transaction::tnx($tnx);

        $status = ucfirst($status);

        if ($status == 'Success' && $tnxInfo->type == TxnType::PlanPurchased) {
            $plan = SubscriptionPlan::find($tnxInfo->plan_id);
            $this->executePlanPurchaseProcess($tnxInfo->user, $plan, $tnxInfo);
        }

        if ($status == 'Pending') {

            $shortcodes = [
                '[[full_name]]' => $tnxInfo->user->full_name,
                '[[txn]]' => $tnxInfo->tnx,
                '[[gateway_name]]' => $tnxInfo->method,
                '[[deposit_amount]]' => $tnxInfo->amount,
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
                '[[message]]' => '',
                '[[status]]' => $status,
            ];

            $this->mailNotify(setting('site_email', 'global'), 'manual_payment_request', $shortcodes);
            $this->pushNotify('manual_payment_request', $shortcodes, route('admin.deposit.manual.pending'), $tnxInfo->user->id, 'Admin');
            $this->smsNotify('manual_payment_request', $shortcodes, $tnxInfo->user->phone);
        }
        app(OrderService::class)->dismissSession();

        return to_route('user.transactions');
    }

    protected function paymentSuccess($ref, $isRedirect = true)
    {
        $txnInfo = Transaction::tnx($ref);
        (new Txn)->update($ref, TxnStatus::Success, $txnInfo->user_id);

        $order = Order::find(session('order_id')) ?? $txnInfo->order;

        if ($order) {
            orderService()->orderPaymentSuccess($order, ! $isRedirect);
        }

        if ($isRedirect) {
            return redirect(URL::temporarySignedRoute(
                'status.success',
                now()->addMinutes(2)
            ));
        }

        return to_route('user.dashboard');

    }

    // automatic gateway map snippet
    private function gatewayMap($gateway, $txnInfo)
    {
        $gatewayMap = [
            'paypal' => PaypalTxn::class,
            'stripe' => StripeTxn::class,
            'mollie' => MollieTxn::class,
            'perfectmoney' => PerfectmoneyTxn::class,
            'coinbase' => CoinbaseTxn::class,
            'paystack' => PaytmTxn::class,
            'voguepay' => BinanceTxn::class,
            'flutterwave' => FlutterwaveTxn::class,
            'cryptomus' => CryptomusTxn::class,
            'nowpayments' => NowpaymentsTxn::class,
            'securionpay' => SecurionpayTxn::class,
            'coingate' => CoingateTxn::class,
            'monnify' => MonnifyTxn::class,
            'coinpayments' => CoinpaymentsTxn::class,
            'paymongo' => PaymongoTxn::class,
            'coinremitter' => CoinremitterTxn::class,
            'btcpayserver' => BtcpayserverTxn::class,
            'binance' => BinanceTxn::class,
            'cashmaal' => CashmaalTxn::class,
            'blockio' => BlockIoTxn::class,
            'blockchain' => BlockchainTxn::class,
            'instamojo' => InstamojoTxn::class,
            'paytm' => PaytmTxn::class,
            'razorpay' => RazorpayTxn::class,
            'twocheckout' => TwocheckoutTxn::class,
        ];
        if (array_key_exists($gateway, $gatewayMap)) {
            return app($gatewayMap[$gateway], ['txnInfo' => $txnInfo]);
        }

        return false;
    }
}
