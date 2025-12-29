<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'seller_id',
        'order_number',
        'gateway_id',
        'listing_id',
        'coupon_id',
        'quantity',
        'unit_price',
        'total_price',
        'discount_amount',
        'payment_status',
        'status',
        'is_topup',
        'delivery_method',
        'delivery_speed',
        'delivery_speed_unit',
        'category_id',
        'org_unit_price',
        'country_tier',
        'country_name',
    ];

    protected $casts = [
        'unit_price' => 'double',
        'total_price' => 'double',
        'discount_amount' => 'double',
    ];

    protected $appends = ['status_badge'];

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'order_id')->latest();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'order_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    /**
     * Get the status
     *
     * @param  string  $value
     * @return string
     */
    public function getStatusBadgeAttribute($value)
    {
        return match ($this->status) {
            OrderStatus::Pending->value => '<span class="badge rounded-pill pending">Pending</span>',
            OrderStatus::Success->value => '<span class="badge rounded-pill success">Success</span>',
            OrderStatus::WaitingForDelivery->value => '<span class="badge badge-2 rounded-pill primary">Waiting For Delivery</span>',
            OrderStatus::Completed->value => '<span class="badge rounded-pill success">Delivered</span>',
            OrderStatus::Cancelled->value => '<span class="badge rounded-pill error">Cancelled</span>',
            OrderStatus::Failed->value => '<span class="badge rounded-pill error">Failed</span>',
            OrderStatus::Refunded->value => '<span class="badge rounded-pill error">Refunded</span>',
            default => '<span class="badge rounded-pill bg-warning">Pending</span>',
        };
    }

    public function deliveryItem()
    {
        return $this->hasMany(DeliveryItem::class, 'order_id');
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->whereAny(['order_number', 'delivery_method'], 'like', '%'.$search.'%');
        }

        return $query;
    }

    public function review()
    {
        return $this->hasOne(ListingReview::class, 'order_id');
    }

    public function scopeStatus($query, $status)
    {
        if ($status && $status != 'all') {
            return $query->where('status', $status);
        }

        return $query;
    }
}
