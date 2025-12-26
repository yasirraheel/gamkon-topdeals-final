<?php

namespace App\Services;

use App\Enums\GatewayType;
use App\Enums\OrderStatus;
use App\Enums\ReferralType;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Facades\Txn\Txn;
use App\Models\DeliveryItem;
use App\Models\Gateway;
use App\Models\Listing;
use App\Models\Order;
use App\Models\Transaction;
use App\Traits\ImageUpload;
use App\Traits\NotifyTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    use ImageUpload;
    use NotifyTrait;

    public function create($isTopup = false, $gateway_code = null, $request = null)
    {

        $checkout = match (true) {
            $isTopup => session('topup'),
            default => session('checkout')
        };

        if ($checkout == null) {
            notify()->error(__('Checkout session expired!'));

            return false;
        }

        DB::beginTransaction();
        try {
            $data = [];

            $orderNumber = Order::max('order_number') + 1;

            if ($orderNumber < 1001) {
                $orderNumber = 1001;
            }

            [$payAmount, $charge, $finalAmount, $gatewayInfo] = getewayPayAmount($gateway_code, $checkout['finalPrice']);

            $listing = Listing::find($checkout['product_id'] ?? 0);
            $data['is_topup'] = (int) $isTopup;
            $data['status'] = OrderStatus::Pending->value;
            $data['buyer_id'] = auth()->user()->id;
            $data['order_number'] = $orderNumber;
            $data['seller_id'] = $listing->seller_id ?? null;
            $data['gateway_id'] = Gateway::where('gateway_code', $gateway_code)?->first()?->id;
            $data['quantity'] = $checkout['quantity'] ?? 0;
            $data['org_unit_price'] = $isTopup ? $checkout['finalPrice'] : $listing->price ?? 0;
            $data['unit_price'] = $isTopup ? $checkout['finalPrice'] : $listing->final_price ?? 0;
            $data['total_price'] = $checkout['finalPrice'] ?? 0;
            $data['listing_id'] = $listing->id ?? null;
            $data['category_id'] = $listing->category_id ?? null;
            $data['coupon_id'] = $checkout['coupon_id'] ?? null;
            $data['payment_status'] = TxnStatus::Pending->value;
            $data['discount_amount'] = $checkout['coupon_discount_amount'] ?? 0;
            $data['delivery_method'] = $listing->delivery_method ?? null;
            $data['delivery_speed'] = $listing->delivery_speed ?? null;
            $data['delivery_speed_unit'] = $listing->delivery_speed_unit ?? null;

            $order = Order::create($data);

            session(['order_id' => $order->id]);

            $authUser = auth()->user();

            // transaction
            $buyerTransaction = Transaction::create([
                'user_id' => $authUser->id,
                'order_id' => $order->id,
                'tnx' => 'TRX' . strtoupper(Str::random(10)),
                'description' => $isTopup ? (($authUser->is_seller ? 'Deposit' : 'Topup') . ' of ' . setting('currency_symbol', 'global') . '' . $checkout['finalPrice']) : 'Order Placed #' . $order->order_number,
                'amount' => $listing->final_price ?? $checkout['finalPrice'],
                'charge' => $charge,
                'type' => $isTopup ? ($authUser->is_seller ? TxnType::Deposit->value : TxnType::Topup->value) : TxnType::ProductOrder->value,
                'status' => TxnStatus::Pending->value,
                'pay_currency' => $gatewayInfo?->currency ?? setting('site_currency', 'global'),
                'pay_amount' => $payAmount,
                'final_amount' => $finalAmount,
                'manual_field_data' => json_encode(processManualDepositData($request) ?? []),
                'method' => $gateway_code ?? 'system',
            ]);

            if ($buyerTransaction->type == TxnType::ProductOrder) {
                $sellerTransaction = $buyerTransaction->replicate();

                $sellerTransaction->user_id = $listing->seller_id;
                $sellerTransaction->type = TxnType::ProductSold->value;
                $sellerTransaction->description = 'Product Sold #' . $order->order_number;
                $sellerTransaction->tnx = 'TRX' . strtoupper(Str::random(10));

                $sellerTransaction->final_amount = $sellerTransaction->amount = $order->total_price;
                $sellerTransaction->charge = 0;
                $sellerTransaction->save();
            }

            DB::commit();

            if (!$isTopup) {
                // Send order created notification for all gateways
                $this->orderCreatedNotify($order);
            }

            return $order;
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;

            return false;
        }
    }

    public function dismissSession()
    {
        session()->forget(['checkout', 'order_id', 'topup']);
    }

    public function orderCreatedNotify(Order $order)
    {

        $shortcodes = [
            '[[full_name]]' => auth()->user()->full_name,
            '[[email]]' => auth()->user()->email,
            '[[order_number]]' => $order->order_number,
            '[[order_date]]' => $order->order_date,
            '[[site_title]]' => setting('site_title', 'global'),
            '[[site_url]]' => route('home'),
            '[[product_names]]' => $order->listing->product_name,
            '[[quantity]]' => $order->quantity,
            '[[total_price]]' => $order->total_price . ' ' . setting('site_currency', 'global'),
            '[[payment_status]]' => ucwords($order->payment_status),
            '[[order_status]]' => ucwords($order->status),
            '[[invoice_link]]' => route('user.purchase.invoice', $order->order_number ?? 0),
        ];

        $this->mailNotify(auth()->user()->email, 'order_placed', $shortcodes);
        
        // Notify Admin using dedicated template
        $this->mailNotify(setting('site_email', 'global'), 'admin_new_order', $shortcodes);

        // Notify Seller
        if ($order->seller) {
            $sellerShortcodes = [
                '[[seller_name]]' => $order->seller->full_name,
                '[[order_number]]' => $order->order_number,
                '[[product_names]]' => $order->listing->product_name,
                '[[quantity]]' => $order->quantity,
                '[[total_price]]' => $order->total_price . ' ' . setting('site_currency', 'global'),
                '[[order_date]]' => $order->order_date,
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
            ];
            $this->mailNotify($order->seller->email, 'seller_new_order', $sellerShortcodes);
        }

        return true;
    }

    public function orderPaymentCompletedNotify(Order $order)
    {

        $shortcodes = [
            '[[full_name]]' => $order->buyer->full_name,
            '[[email]]' => $order->buyer->email,
            '[[order_number]]' => $order->order_number,
            '[[payment_date]]' => now()->format('Y-m-d'),
            '[[site_title]]' => setting('site_title', 'global'),
            '[[site_url]]' => route('home'),
            '[[payment_amount]]' => $order->total_price . ' ' . setting('site_currency', 'global'),
            '[[payment_status]]' => ucwords($order->payment_status),
            '[[order_status]]' => ucwords($order->status),
            '[[invoice_link]]' => route('user.purchase.invoice', $order->order_number ?? 0),
        ];
        $this->pushNotify('order_payment_completed', $shortcodes, route('user.purchase.invoice', $order->order_number ?? 0), auth()->id());

        $this->mailNotify($order->buyer->email, 'order_payment_completed', $shortcodes);
        // Notify Admin
        $this->mailNotify(setting('site_email', 'global'), 'order_payment_completed', $shortcodes);

        return true;
    }

    public function orderDeliveryWithNotify(Order $order)
    {
        $deliveryItem = $order->listing->deliveryItems()
            ->where(function ($q) use ($order) {
                $q->whereNull('order_id')->orWhere('order_id', $order->id);
            })
            ->whereNotNull('data')->oldest('id')->take($order->quantity);

        // dd($deliveryItem->get());

        if ($deliveryItem->count() < $order->quantity) {

            $order->update(attributes: ['status' => OrderStatus::WaitingForDelivery->value, 'delivery_method' => 'manual']);

            $deliveryItemEmpty = $order->listing->deliveryItems()->whereNull('order_id')->whereNull('data')->oldest('id');
            $deliveryItemEmptyCount = $deliveryItemEmpty->count();
            $deliveryItemEmpty->take($order->quantity)->update(['order_id' => $order->id]);

            // need to create new delivery items
            if ($order->quantity > $deliveryItemEmptyCount) {
                DeliveryItem::createNew($order->quantity - $deliveryItemEmptyCount, $order->listing, $order->id);
            }

            $this->orderWaitingForDeliveryNotify($order);

            return false;
        }
        $order->update(['status' => OrderStatus::Completed->value]);

        $sellerTrx = Transaction::where('order_id', $order->id)->where('type', TxnType::ProductSold);

        $sellerTrx->update(['status' => TxnStatus::Success->value]);

        $deliveryItem->update(['order_id' => $order->id]);

        $orderDeliveryItemsList = $deliveryItem->pluck('data')->implode('<br>');

        $shortcodes = [
            '[[full_name]]' => $order->buyer->full_name,
            '[[email]]' => $order->buyer->email,
            '[[order_number]]' => $order->order_number,
            '[[delivery_date]]' => now()->format('Y-m-d'),
            '[[site_title]]' => setting('site_title', 'global'),
            '[[site_url]]' => route('home'),
            '[[delivery_items]]' => $orderDeliveryItemsList,
            '[[invoice_link]]' => route('user.purchase.invoice', $order->order_number ?? 0),
        ];
        $this->pushNotify('order_delivery', $shortcodes, route('user.purchase.index'), auth()->id());

        $this->mailNotify($order->buyer->email, 'order_delivery', $shortcodes);
        $deliveryItem->update(['is_used' => 1]);

        // check if subscriptions first order bonus

        if (
            setting('subscribed_user_first_order_bonus', 'fee')

            && $order->buyer->transaction()->where('type', TxnType::ProductOrder)->count() == 1

        ) {
            $bonusAmount = setting('subscribed_user_first_order_bonus_type', 'fee') == 'fixed' ? (float) setting('subscribed_user_first_order_bonus_amount', 'fee') : (float) setting('subscribed_user_first_order_bonus_amount', 'fee') / 100;

            $order->buyer()->increment('balance', $bonusAmount);

            app(Txn::class)->new(
                $bonusAmount,
                0,
                $bonusAmount,
                'system',
                'Subscribed User First Order Bonus',
                TxnType::SubscribedUserFirstOrder,
                TxnStatus::Success,
                setting('site_currency', 'global'),
                $bonusAmount,
                $order->buyer_id
            );
        }

        return true;
    }

    public function orderWaitingForDeliveryNotify(Order $order)
    {
        // seller

        $sellerShortcodes = [
            '[[seller_name]]' => $order->seller->full_name,
            '[[order_number]]' => $order->order_number,
            '[[full_name]]' => $order->buyer->full_name,
            '[[email]]' => $order->buyer->email,
            '[[update_items_link]]' => route('user.listing.delivery-items', [
                'id' => $order->listing->enc_id,
                'order_id' => $order->id,
            ]),
            '[[site_title]]' => setting('site_title', 'global'),
            '[[site_url]]' => route('home'),
        ];

        $this->mailNotify(
            $order->seller->email,
            'waiting_for_delivery_seller',
            $sellerShortcodes
        );

        // push notification for seller

        $sellerShortcodes = [
            '[[order_number]]' => $order->order_number,
            '[[update_items_link]]' => route('user.listing.delivery-items', [
                'id' => $order->listing->enc_id,
                'order_id' => $order->id,
            ]),
        ];

        $this->pushNotify(
            'waiting_for_delivery_seller',
            $sellerShortcodes,
            route('user.listing.delivery-items', [
                'id' => $order->listing->enc_id,
                'order_id' => $order->id,
            ]),
            $order->seller->id,
            'User'
        );

        // buyer
        $buyerShortcodes = [
            '[[full_name]]' => $order->buyer->full_name,
            '[[email]]' => $order->buyer->email,
            '[[order_number]]' => $order->order_number,
            '[[delivery_date]]' => now()->format('Y-m-d'),
            '[[site_title]]' => setting('site_title', 'global'),
            '[[site_url]]' => route('home'),
            '[[delivery_items]]' => $order->listing->product_name,
            '[[invoice_link]]' => route('user.purchase.invoice', $order->order_number ?? 0),
        ];

        $this->mailNotify(
            $order->buyer->email,
            'waiting_for_delivery_buyer',
            $buyerShortcodes
        );
    }

    public function setTrnxId(Order $order, $trnxId)
    {
        $order?->update(['transaction_id' => $trnxId]);
    }

    public function getSellerTrnx(Order $order)
    {
        return Transaction::where('order_id', $order->id)->where('type', TxnType::ProductSold)->first();
    }

    public function orderPaymentSuccess(Order $order, $sessionDismiss = true)
    {
        DB::beginTransaction();

        // check qty

        if (!$order->is_topup && $order->quantity > $order->listing->quantity) {

            // Refund
            $this->setOrderRefunded($order, $sessionDismiss, true);

            notify()->error(__('Quantity is not available!'));

            return false;
        }

        $order->update(['payment_status' => TxnStatus::Success->value, 'status' => OrderStatus::Success->value]);

        // buyer trnx success
        $order->transactions()->update(['status' => TxnStatus::Success->value]);

        // seller trnx success

        if ($sessionDismiss) {
            if ($order->transaction->type == TxnType::ProductOrder) {
                $sellerTrx = Transaction::where('order_id', $order->id)->where('type', TxnType::ProductSold);

                $order->seller()->increment('total_sold', $order->quantity);
                $order->seller()->increment('total_amount_sold', $order->total_price);

                $order->seller()->increment('balance', $sellerTrx->first()->amount);

            }
            $this->orderPaymentCompletedNotify($order);

            $order->listing()->increment('sold_count', $order->quantity);
            $order->listing()->decrement('quantity', $order->quantity);

            if ($order->coupon_id) {
                $order->coupon()->increment('total_used');
            }

            if (!$order->is_topup) {
                // buyer
                $order->buyer()->increment('total_purchased');
                $order->buyer()->increment('total_amount_purchased', $order->total_price);

                // add seller fee transaction
                if ($order->listing->seller->hasValidSubscription) {
                    $sellerCurrentPlan = $order->listing->seller->currentPlan;
                    if ($sellerCurrentPlan->charge_type == 'amount') {
                        $sellerCharge = $sellerCurrentPlan->charge_value;
                    } else {
                        $sellerCharge = ($order->total_price * $sellerCurrentPlan->charge_value) / 100;
                    }
                    // create new transaction
                    app(Txn::class)->new(
                        $sellerCharge,
                        0,
                        $sellerCharge,
                        'system',
                        'Seller Fee for Order #' . $order->order_number,
                        TxnType::SellerFee,
                        TxnStatus::Success,
                        setting('site_currency', 'global'),
                        $sellerCharge,
                        $order->seller_id
                    );

                    $order->seller()->decrement('balance', $sellerCharge);
                }
            }

            if (setting('deposit_level') && $order->transaction->type == TxnType::Topup) {
                $level = getReferralLevel($order->transaction->user_id);
                creditReferralBonus($order->transaction->user, ReferralType::Topup->value, $order->transaction->amount - $order->transaction->charge, $level);
            }

            if (setting('product_order_level') && $order->transaction->type == TxnType::ProductOrder) {
                $level = getReferralLevel($order->transaction->user_id);
                creditReferralBonus($order->transaction->user, ReferralType::ProductOrder->value, $order->transaction->amount - $order->transaction->charge, $level);
            }

            if ($order->is_topup) {
                $order->buyer()->increment($order->buyer->is_seller ? 'balance' : 'topup_balance', $order->is_topup ? $order->unit_price : $order->total_price);
            } else {
                $this->orderDeliveryWithNotify($order);
            }

            $this->dismissSession();
        }
        DB::commit();

        return $order;
    }

    public function setOrderFailed(Order $order, $sessionDismiss = true)
    {
        DB::beginTransaction();
        $order->update(['payment_status' => TxnStatus::Failed->value, 'status' => OrderStatus::Failed->value]);
        $order->transaction()->update(['status' => TxnStatus::Failed->value]);
        DB::commit();

        if ($sessionDismiss) {
            $this->dismissSession();
        }
    }

    public function setOrderRefunded(Order $order, $sessionDismiss = true, $qtyFailed = false)
    {
        DB::beginTransaction();
        $order->update(['payment_status' => TxnStatus::Failed->value, 'status' => OrderStatus::Refunded->value]);
        $order->transaction()->update(['status' => TxnStatus::Failed->value]);
        // refund money to buyer
        $order->buyer()->increment('topup_balance', $order->total_price);
        (new Txn)->new($order->total_price, 0, $order->total_price, 'system', 'Refund for Order #' . $order->order_number, TxnType::OrderRefunded, TxnStatus::Success, null, null, $order->buyer_id);


        if (!$qtyFailed) {
            // decrease seller's sold count and amount
            $order->seller()->decrement('total_sold', $order->quantity);
            $order->seller()->decrement('total_amount_sold', $order->total_price);
            $order->seller()->decrement('balance', $order->total_price);
            $order->listing()->decrement('sold_count', $order->quantity);
            $order->listing()->increment('quantity', $order->quantity);
        }


        if ($order->coupon_id) {
            $order->coupon()->decrement('total_used');
        }
        if ($order->transaction->type == TxnType::ProductOrder) {
            $sellerTrx = Transaction::where('order_id', $order->id)->where('type', TxnType::ProductSold);
            $sellerTrx->update(['status' => TxnStatus::Refunded->value]);
            $sellerTrx->decrement('amount', $order->total_price);
        }
        $order->listing->deliveryItems()->where('order_id', $order->id)->update(['order_id' => null, 'is_used' => 0]);

        DB::commit();

        if ($sessionDismiss) {
            $this->dismissSession();
        }
    }

    public function setOrderCancelled(Order $order, $sessionDismiss = true)
    {
        DB::beginTransaction();
        $order->update(['payment_status' => TxnStatus::Cancelled->value, 'status' => OrderStatus::Cancelled->value]);
        $order->transaction()->update(['status' => TxnStatus::Cancelled->value]);
        DB::commit();

        if ($sessionDismiss) {
            $this->dismissSession();
        }
    }
}
