<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_catalog_id',
        'plan_name',
        'description',
        'status',
        'order',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the product catalog that owns the plan
     */
    public function productCatalog()
    {
        return $this->belongsTo(ProductCatalog::class);
    }

    /**
     * Scope a query to only include active plans
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
