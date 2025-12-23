<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'features' => 'array',
    ];

    protected $guarded = ['id'];

    /**
     * Get the chargeAmount
     *
     * @param  string  $value
     * @return string
     */
    public function getChargeAmountAttribute($value)
    {
        if ($this->charge_type == 'fixed') {
            return $this->charge_value;
        }

        return ($this->charge_value / 100) * $this->price;

    }
}
