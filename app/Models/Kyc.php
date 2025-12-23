<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Scope a query to only include sellerVerification
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSellerVerification($query)
    {
        return $query->where('is_seller_kyc', 1);
    }

    /**
     * Scope a query to only include userWise
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUserWise($query, $user = null)
    {
        $user = $user ?? auth()->user();
        $is_seller = $user->is_seller;

        return $query->where(function ($q) use ($is_seller) {
            $q->when($is_seller, function ($query) {
                $query->where('user_type', 'seller')->orWhere('user_type', 'both');
            }, function ($query) {
                $query->where('user_type', 'buyer')->orWhere('user_type', 'both');
            });
        });
    }
}
