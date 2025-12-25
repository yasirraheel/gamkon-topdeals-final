<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\DepositMethod;
use App\Models\Listing;
use App\Models\SubscriptionPlan;
use App\Traits\NotifyTrait;
use App\Traits\Payment;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    use NotifyTrait;
    use Payment;

    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:listings,id',
            'quantity' => 'required|integer',
        ]);

        $listing = Listing::public()->find($request->product_id);

        if (!$listing) {
            notify()->error(__('Product may not available!'));

            return back();
        }

        if ($listing->quantity < $request->quantity) {
            notify()->error(__('Insufficient quantity!'));

            return back();
        } elseif ($listing->status == 0) {
            notify()->error(__('Product is not available!'));

            return back();
        } elseif ($listing->seller_id == auth()->id()) {
            notify()->error(__('You can not purchase your own product!'));

            return back();
        }

        $checkoutData = [
            'product_id' => $listing->id,
            'quantity' => $request->quantity,
            'finalPrice' => $listing->final_price * $request->quantity,
            'subtotal' => $listing->final_price * $request->quantity,
        ];

        if ($request->coupon) {
            $coupon = Coupon::approved()->whereCode($request->coupon)->first();

            $error = match (true) {
                !$coupon => __('Invalid coupon!'),
                $coupon->expires_at->isPast() => __('Coupon expired!'),
                $coupon->max_use_limit <= $coupon->total_used => __('Coupon limit reached!'),
                $coupon->status == 0 => __('Coupon disabled!'),
                $coupon->seller_id != $listing->seller_id => __('Coupon not applicable!'),
                default => null
            };

            if ($error !== null) {
                notify()->error($error);

                return back();
            }
            $checkoutData['coupon_id'] = $coupon->id;
            $checkoutData['coupon_discount_amount'] = $coupon->discount_type == 'percentage' ? ($coupon->discount_value / 100) * $listing->final_price : $coupon->discount_value;
            $checkoutData['finalPrice'] = $checkoutData['finalPrice'] - $checkoutData['coupon_discount_amount'];
        }

        session([
            'checkout' => $checkoutData,
        ]);

        return to_route('checkout');
    }

    public function checkout(Request $request, $type = null, $data = null)
    {
        // kyc purchase
        if (!setting('kyc_purchase') && (auth()->user()->kyc == 0 || auth()->user()->kyc == 2)) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_buyerSellerRoute('kyc');
        }

        if ($type == 'plan') {
            $plan = SubscriptionPlan::findOrFail($request->data);
            $planPrice = $plan->price;
            $checkout['total'] = $checkout['subtotal'] = $checkout['finalPrice'] = $planPrice;
            $checkout['plan_data'] = $plan;

            if (!auth()->user()->is_seller) {
                notify()->error(__('You must be a seller to purchase a subscription plan.'));
                return back();
            }

            session([
                'checkout' => $checkout,
            ]);

            return view('frontend::checkout.index', compact('checkout'));
        }
        $checkout = session('checkout');

        // check if checkout session is empty
        if (!$checkout) {
            notify()->error(__('Checkout session expired!'));

            return back();
        }

        // check if product is available
        $listing = Listing::findOrFail($checkout['product_id']);
        // check quantity
        if ($listing->quantity < $checkout['quantity']) {
            notify()->error(__('Insufficient quantity!'));

            return back();
        }

        $checkout['total'] = $checkout['finalPrice'];
        $checkout['coupon'] = Coupon::find($checkout['coupon_id'] ?? null);

        return view('frontend::checkout.index', compact('listing', 'checkout'));
    }

    public function payment(Request $request)
    {

        $request->validate([
            'paymentMethod' => in_array($request->paymentMethod, ['topup', 'balance']) ? 'nullable' : 'required',
        ]);

        if (session('checkout') == null) {
            notify()->error(__('Checkout session expired!'));

            return to_buyerSellerRoute('dashboard');
        }

        if ($request->paymentMethod == 'topup' && auth()->user()->topup_balance < session('checkout')['finalPrice']) {
            notify()->error(__('Insufficient topup balance!'));

            return back();
        }

        $error = match (true) {
            in_array($request->paymentMethod, ['balance']) && auth()->user()->balance < session('checkout')['finalPrice'] => __('Insufficient Balance.'),
            in_array($request->paymentMethod, ['topup']) && auth()->user()->topup_balance < session('checkout')['finalPrice'] => __('Insufficient Topup Balance.'),
            default => null
        };

        if ($error !== null) {
            notify()->error($error);

            return back();
        }

        // check if plan

        if (isset(session('checkout')['plan_data'])) {

            $subscription = app(SubscriptionController::class);
            $request->merge([
                'plan_id' => session('checkout')['plan_data']->id,
                'method' => in_array($request->paymentMethod, ['topup', 'balance']) ? $request->paymentMethod : 'gateway',
                'gateway_code' => $request->paymentMethod ?? null,
            ]);

            return $subscription->subscriptionNow($request);
        }

        $gateway = DepositMethod::where('gateway_code', $request->paymentMethod)->first();
        if (!in_array($request->paymentMethod, ['topup', 'balance']) && !$gateway) {
            notify()->error(__('Invalid payment method!'));

            return back();
        }

        // Validate gateway configuration for automatic gateways
        if ($gateway && $gateway->gateway_code == 'paypal') {
            $paypalConfig = config('paypal');
            $mode = $paypalConfig['mode'] ?? 'live';
            $credentials = $paypalConfig[$mode] ?? [];
            
            if (empty($credentials['client_id']) || empty($credentials['client_secret'])) {
                notify()->error(__('PayPal payment method is not properly configured. Please choose another payment method or contact support.'));
                return back();
            }
        }

        $gateway_code = $gateway?->gateway_code ?? null;

        $service = orderService();

        $order = $service->create(false, $gateway_code, $request);

        if (!$order) {
            $listingId = session('checkout')['product_id'] ?? 0;
            $service->dismissSession();

            notify()->error(__('Can not create order!'));

            return to_route('listing.details', Listing::findOrFail($listingId)?->slug);
        }
        $order = $order->refresh();

        if ($request->paymentMethod == 'topup') {
            $order->buyer()->decrement('topup_balance', $order->total_price);
            $service->orderPaymentSuccess($order, true);
            notify()->success(__('Purchase successful!'));

            return to_buyerSellerRoute('purchase.success', $order->order_number);
        } elseif ($request->paymentMethod == 'balance') {
            $order->buyer()->decrement('balance', $order->total_price);
            $service->orderPaymentSuccess($order, true);
            notify()->success(__('Purchase successful!'));

            return to_buyerSellerRoute('purchase.success', $order->order_number);
        }

        $order->transaction->order = $order;
        $order->transaction->listing = $order->listing;

        return $this->depositAutoGateway($gateway->gateway_code, $order->transaction);
    }
}
