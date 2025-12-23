<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\OrderStatus;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SellController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'sort' => 'nullable|in:price-asc,price-desc,latest,oldest',
        ]);
        $user = auth()->user();
        $orders = Order::whereBelongsTo(auth()->user(), 'seller')
            ->when($request->sort, function ($query) use ($request) {
                match ($request->sort) {
                    'price-asc' => $query->orderBy('total_price', 'asc'),
                    'price-desc' => $query->orderBy('total_price', 'desc'),
                    'latest' => $query->orderBy('created_at', 'desc'),
                    'oldest' => $query->orderBy('created_at', 'asc'),
                };
            })
            ->latest()
            ->paginate(15);

        $totalSold = Transaction::where('type', TxnType::ProductSold->value)
            ->whereBelongsTo($user, 'user')
            ->where('status', TxnStatus::Success->value)
            ->sum('amount');

        $totalOrders = Order::where('seller_id', $user->id)
            ->whereIn('status', [OrderStatus::Success->value, OrderStatus::Completed->value])
            ->count();

        $successRate = $user->order_success_rate;

        $totalRevenue = Order::where('seller_id', $user->id)
            ->whereIn('status', [OrderStatus::Completed->value])
            ->sum('total_price');

        return view('frontend::sell.index', compact('orders', 'totalSold', 'totalOrders', 'successRate', 'totalRevenue'));
    }

    public function refund(Order $order)
    {
        abort_if(! $order || $order->seller_id != auth()->id(), 404);
        orderService()->setOrderRefunded($order);

        notify()->success(__('Refund successful!'));

        return back();
    }
}
