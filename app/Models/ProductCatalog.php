<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCatalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'thumbnail',
        'durations',
        'sharing_methods',
        'plans',
        'regions',
        'platforms',
        'description',
        'status',
        'order',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'durations' => 'array',
        'sharing_methods' => 'array',
        'plans' => 'array',
        'regions' => 'array',
        'platforms' => 'array',
        'status' => 'boolean',
    ];

    /**
     * Scope a query to only include active catalogs
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Get associated subscription plans
     */
    public function subscriptionPlans()
    {
        if (empty($this->plans)) {
            return collect();
        }

        return SubscriptionPlan::whereIn('id', $this->plans)->get();
    }

    /**
     * Get associated account plans
     */
    public function accountPlans()
    {
        return $this->hasMany(AccountPlan::class)->orderBy('order', 'asc');
    }
}
