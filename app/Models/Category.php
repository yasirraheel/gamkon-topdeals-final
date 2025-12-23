<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_title',
        'description',
        'image',
        'order',
        'status',
        'slug',
        'is_trending',
        'in_landing_hero',
        'parent_id',
    ];

    /**
     * Scope a query to only include active
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'category_id');
    }

    public function subCategoryListing()
    {
        return $this->hasMany(Listing::class, 'subcategory_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Scope a query to only include isCategory
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsCategory($query)
    {
        return $query->where('parent_id', null);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (Category $category) {
            $category->slug = \Str::slug($category->name);

            if (self::where('slug', $category->slug)->exists()) {
                $category->slug = $category->slug.'-'.self::max('id');
            }
        });
    }

    /**
     * Scope a query to only include trending
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTrending($query)
    {
        return $query->where('is_trending', 1);
    }

    public function scopeIsLandingHero($query)
    {
        return $query->where('in_landing_hero', 1);
    }
}
