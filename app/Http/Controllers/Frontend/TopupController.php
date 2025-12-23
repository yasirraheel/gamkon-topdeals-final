<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\Payment;
use Illuminate\Http\Request;

class TopupController extends Controller
{
    use Payment;

    public function __construct() {}

    public function index()
    {
        if (! setting('user_deposit', 'permission')) {
            notify()->error(__('Topup currently unavailable'), 'Error');

            return to_buyerSellerRoute('dashboard');
        } elseif (! setting('kyc_'.auth()->user()->user_type.'_deposit', 'kyc') && (auth()->user()->kyc == 0 || auth()->user()->kyc == 2)) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_buyerSellerRoute('dashboard');
        }

        return view('frontend::topup.index');
    }

    public function purchase(Request $request)
    {

        if (! setting('user_deposit', 'permission')) {
            notify()->error(__('Topup currently unavailable'), 'Error');

            return to_buyerSellerRoute('dashboard');
        } elseif (! setting('kyc_'.auth()->user()->user_type.'_deposit', 'kyc', 'kyc') && (auth()->user()->kyc == 0 || auth()->user()->kyc == 2)) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_buyerSellerRoute('dashboard');
        }

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'paymentMethod' => 'required:paymentMethod',
        ]);

        $service = orderService();

        session([
            'topup' => [
                'finalPrice' => $request->amount,
            ],
        ]);
        $order = $service->create(true, $request->paymentMethod, $request);

        if (! $order) {
            $service->dismissSession();
            notify()->error(__('Count not create order!'));

            return back();
        }

        $order = $order->refresh();

        if (! $order) {
            $service->dismissSession();
            notify()->error(__('Count not create order!'));

            return back();
        }

        $order->transaction->order = $order;
        $order->transaction->listing = $order->listing;

        return $this->depositAutoGateway($request->paymentMethod, $order->transaction);
    }
}
