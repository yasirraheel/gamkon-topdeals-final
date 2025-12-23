<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id', 'listing_id', 'data', 'is_used'];

    public static function createNew($qty, $listing, $order_id = null)
    {
        foreach (range(1, $qty) as $key => $value) {
            self::create([
                'listing_id' => $listing->id,
                'order_id' => $order_id,
            ]);
        }
    }

    /**
     * Scope a query to only include deliveryAble
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDeliveryAble($query)
    {
        return $query->whereNotNull('data')->where('is_used', 0);
    }
}
