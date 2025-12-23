<?php

namespace App\Models;

use App\Traits\ModelIdEncDec;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    use ModelIdEncDec;

    protected $fillable = [
        'seller_id',
        'category_id',
        'product_name',
        'description',
        'price',
        'discount_type',
        'discount_value',
        'quantity',
        'thumbnail',
        'delivery_method',
        'delivery_speed_unit',
        'delivery_speed',
        'status',
        'slug',
        'is_approved',
        'is_trending',
        'is_flash',
        'avg_rating',
        'subcategory_id',
    ];

    protected $appends = [
        'final_price',
        'statusBadge',
        'thumbnailUrl',
        'average_rating',
        'total_reviews',
    ];

    public function images()
    {
        return $this->hasMany(ListingGallery::class, 'listing_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    /**
     * Scope a query to only include active
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get the url
     *
     * @param  string  $value
     * @return string
     */
    public function getURLAttribute($value)
    {
        return route('listing.details', [
            'slug' => $this->slug,
        ]);
    }

    /**
     * Get the final_price
     *
     * @param  string  $value
     * @return string
     */
    public function getFinalPriceAttribute($value)
    {
        return $this->discount_type == 'percentage' ? $this->price - ($this->price * $this->discount_value / 100) : $this->price - $this->discount_value;
    }

    public function getDiscountAmountAttribute($value)
    {
        return $this->discount_type == 'percentage' ? $this->price * $this->discount_value / 100 : $this->discount_value;
    }

    public function getThumbnailUrlAttribute($value)
    {
        return asset($this->thumbnail);
    }

    /**
     * Get the statusBadge
     *
     * @param  string  $value
     * @return string
     */
    public function getStatusBadgeAttribute($value)
    {
        return match ($this->status) {
            'draft' => '<span class="badge rounded-pill bg-warning text-black">Draft</span>',
            'active' => '<span class="badge rounded-pill bg-success">Active</span>',
            'inactive' => '<span class="badge rounded-pill bg-danger">Inactive</span>',
            'pending' => '<span class="badge rounded-pill bg-primary">Pending</span>',
            'rejected' => '<span class="badge rounded-pill bg-danger">Rejected</span>',
            default => '<span class="badge rounded-pill bg-warning">Draft</span>',
        };
    }

    public function analysis()
    {
        return $this->hasMany(ListingAnalysis::class, 'listing_id');
    }

    public static function findOwn($id, $columns = ['*'])
    {
        return self::where('id', $id)->where('seller_id', auth()->id())->firstOrFail($columns);
    }

    /**
     * Scope a query to only include search
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $q)
    {
        return $query->where('product_name', 'LIKE', '%' . $q . '%')
            ->orWhere('description', 'LIKE', '%' . $q . '%');
    }

    /**
     * Scope a query to only include status
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        if ($status && $status !== 'all') {
            return $query->where('status', $status);
        }

        return $query;
    }

    /**
     * Scope a query to only include public
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublic($query)
    {
        return $query->where('status', 'active')->where('is_approved', 1)
            ->where(function (Builder $q) {
                $q->where('delivery_method', 'auto')->whereHas('deliveryItems', function (Builder $q) {
                    $q->deliveryAble()->whereNull('order_id');
                })->orWhere('delivery_method', 'manual');
            });
    }

    public function deliveryItems()
    {
        return $this->hasMany(DeliveryItem::class, 'listing_id');
    }

    public function deliveryItemsNoData()
    {
        return $this->hasMany(DeliveryItem::class, 'listing_id')->whereNull('data');
    }

    public function reviews()
    {
        return $this->hasMany(ListingReview::class, 'listing_id');
    }

    public function approvedReviews()
    {
        return $this->hasMany(ListingReview::class, 'listing_id')->whereNull('parent_id')->where('status', 'approved');
    }

    /**
     * Get average rating attribute
     */
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?: 0;
    }

    /**
     * Get total reviews attribute
     */
    public function getTotalReviewsAttribute()
    {
        return $this->approvedReviews()->count();
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

    public function orders()
    {
        return $this->hasMany(Order::class, 'listing_id');
    }

    /**
     * Get the admin URL for the listing
     *
     * @return string
     */
    public function getAdminUrlAttribute()
    {
        return route('listing.details', [
            'slug' => $this->slug,
            'encrypt' => $this->enc_id,
        ]);
    }
}
