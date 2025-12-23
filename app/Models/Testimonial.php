<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'locale' => 'string',
    ];

    public function trans()
    {
        return $this->hasMany(Testimonial::class, 'locale_id');
    }

    /**
     * Get the translated
     *
     * @param  string  $value
     * @return string
     */
    public function getTranslatedAttribute($value)
    {
        return $this->trans()->where('locale', app()->getLocale())->first() ?? $this;
    }
}
