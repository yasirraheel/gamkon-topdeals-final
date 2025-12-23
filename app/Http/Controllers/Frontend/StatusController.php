<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\TxnStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use App\Traits\NotifyTrait;
use App\Traits\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Txn;

class StatusController extends Controller
{
    use NotifyTrait;
    use Payment;

    public function __destruct()
    {
    }

    public function pending(Request $request)
    {
        $depositTnx = Session::get('deposit_tnx');

        if (session('order_id')) {
            notify()->warning(__('Payment Pending, Status will be updated soon'));

            return redirect(buyerSellerRoute('dashboard'))->setStatusCode(200);
        }

        return self::paymentNotify($depositTnx, 'pending');
    }

    public function success(Request $request)
    {
        if (isset($request->reftrn)) {
            $ref = Crypt::decryptString($request->reftrn);

            return self::paymentSuccess($ref);
        }
        if (session('order_id')) {
            $order = Order::find(session('order_id')) ?? Transaction::tnx($request->reftrn)->order;
            $transaction = orderService()->orderPaymentSuccess($order)->transaction->tnx;
            if ($order->is_topup) {
                notify()->success(__('Topup Successful'));

                return to_buyerSellerRoute('transactions');
            }
            notify()->success(__('Payment Successful'));

            return redirect(buyerSellerRoute('purchase.success', $order->order_number))->setStatusCode(200);
        } elseif (session('deposit_tnx')) {
            $transaction = Session::get('deposit_tnx');
        } else {
            notify()->warning(__('Payment Failed'));

            return to_buyerSellerRoute('dashboard');
        }

        return self::paymentNotify($transaction, 'success');

    }

    public function cancel(Request $request)
    {
        $trx = Session::get('deposit_tnx');
        Txn::update($trx, TxnStatus::Cancelled->value);

        if (session('order_id')) {
            $order = Order::find(session('order_id'));

        } else {
            $order = Transaction::tnx($request->reftrn ?? $trx)->order;
        }
        orderService()->setOrderCancelled($order);
        notify()->warning(__('Payment Canceled'));

        return redirect(buyerSellerRoute('dashboard'))->setStatusCode(200);
    }
}
