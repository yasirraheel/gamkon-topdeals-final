<?php

namespace App\Models;

use App\Enums\NavigationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'json',
    ];

    protected $guarded = ['id'];

    public function page()
    {
        return $this->belongsTo(Page::class)->withDefault();
    }

    public function getTnameAttribute()
    {
        if ($this->translate != null) {
            $jsonData = json_decode($this->translate, true);
        }

        return $jsonData[session()->get('locale') ?? config('app.locale')] ?? $this->name;
    }

    /**
     * Scope a query to only include footer
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFooter($query)
    {
        return $query->where('type', 'like', '%footer-%');
    }

    public function scopeHeader($query)
    {
        return $query->where('type', 'like', '%'.NavigationType::Header->value.'%');
    }
}
