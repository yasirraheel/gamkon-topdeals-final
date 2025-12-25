<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AverageDeliveryTimeService
{
    /**
     * Minimum number of orders required to use calculated average.
     */
    const MIN_ORDERS_THRESHOLD = 5;

    /**
     * Calculate and update average delivery time for a seller.
     *
     * @param User $seller
     * @return int|null Average delivery time in minutes, or null if insufficient data
     */
    public function calculateForSeller(User $seller)
    {
        if (!$seller->is_seller) {
            return null;
        }

        $completedOrders = Order::where('seller_id', $seller->id)
            ->where('status', OrderStatus::Completed->value)
            ->whereNotNull('created_at')
            ->whereNotNull('updated_at') // Assuming updated_at is delivery time for Completed status
            ->get();

        if ($completedOrders->count() < self::MIN_ORDERS_THRESHOLD) {
            return null; // Insufficient data
        }

        $totalDurationMinutes = 0;
        $count = 0;

        foreach ($completedOrders as $order) {
            $created = Carbon::parse($order->created_at);
            $delivered = Carbon::parse($order->updated_at);
            
            // Only count if delivered after created (sanity check)
            if ($delivered->gt($created)) {
                $duration = $created->diffInMinutes($delivered);
                $totalDurationMinutes += $duration;
                $count++;
            }
        }

        if ($count === 0) {
            return null;
        }

        $averageMinutes = (int) round($totalDurationMinutes / $count);

        // Update seller record
        $seller->update(['average_delivery_time' => $averageMinutes]);

        return $averageMinutes;
    }

    /**
     * Get the display text for average delivery time.
     *
     * @param User $seller
     * @param string|null $fallbackGuarantee Time string like "1 Hour"
     * @return array ['text' => string, 'is_estimated' => bool]
     */
    public function getDeliveryTimeDisplay(User $seller, $fallbackGuarantee = null)
    {
        $avgMinutes = $seller->average_delivery_time;

        if ($avgMinutes !== null) {
            return [
                'text' => $this->formatDuration($avgMinutes),
                'is_estimated' => false
            ];
        }

        // Fallback
        return [
            'text' => $fallbackGuarantee ?? 'Instant', // Default fallback
            'is_estimated' => true
        ];
    }

    /**
     * Format minutes into readable string.
     *
     * @param int $minutes
     * @return string
     */
    protected function formatDuration($minutes)
    {
        if ($minutes < 60) {
            return $minutes . ' ' . __('mins');
        }

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        if ($remainingMinutes > 0) {
            return $hours . ' ' . __('hr') . ' ' . $remainingMinutes . ' ' . __('min');
        }

        return $hours . ' ' . __('hr');
    }
}
