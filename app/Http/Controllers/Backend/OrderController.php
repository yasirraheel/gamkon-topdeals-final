<?php

namespace App\Http\Controllers\Backend;

use App\Enums\OrderStatus;
use App\Enums\TxnStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 15;
        $search = $request->search ?? null;
        $status = $request->status ?? 'all';
        $orders = Order::search($search)
            ->status($status)
            ->when(in_array($request->get('sort_field'), ['created_at', 'total_price', 'order_number']), function ($query) use ($request) {
                $query->orderBy($request->get('sort_field'), $request->get('sort_dir'));
            }, function ($query) {
                $query->latest();
            })
            ->paginate($perPage);

        return view('backend.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if(!$order, 404);
        $order = $order->load(['listing', 'transaction']);

        $paymentStatus = TxnStatus::cases();
        $orderStatus = OrderStatus::cases();

        return view('backend.order.show', compact('order', 'paymentStatus', 'orderStatus'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        abort_if(!$order, 404);
        abort_if(!$request->user()->can('order-update'), 403);
        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);
        $order->transaction->update([
            'status' => $request->payment_status,
        ]);
        $service = orderService();
        if ($request->payment_status == TxnStatus::Success->value && $order->status != OrderStatus::Success->value) {
            $service->orderPaymentSuccess($order, false);
        }
        if ($request->status == OrderStatus::Cancelled->value) {
            $service->setOrderCancelled($order, false);
        } elseif ($request->status == OrderStatus::Failed->value) {
            $service->setOrderFailed($order, false);
        } elseif ($request->status == OrderStatus::Refunded->value && $order->status != OrderStatus::Refunded->value) {
            $service->setOrderRefunded($order, false, true);
        } elseif ($request->status == OrderStatus::WaitingForDelivery->value) {
            $service->orderWaitingForDeliveryNotify($order);
        }

        notify()->success(__('Order Status Updated Successfully'));

        return back();
    }
}
