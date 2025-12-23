<?php

namespace App\Models;

use App\Traits\ModelIdEncDec;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    use ModelIdEncDec;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'expires_at',
        'max_use_limit',
        'total_used',
        'seller_id',
        'admin_approval',
        'status',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Scope a query to only include approved
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('admin_approval', 1);
    }

    /**
     * Get the expires_at
     *
     * @param  string  $value
     * @return string
     */
    public function getExpiresAtAttribute($value)
    {
        return now()->parse($value)->setTime(23, 59, 59);
    }
}
