<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;

class PublicListingController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 20);
        
        $listings = Listing::with(['productCatalog', 'seller', 'category'])
            ->public()
            ->latest()
            ->paginate($limit);

        // Transform data to match product card structure
        $data = $listings->map(function ($listing) {
            return [
                'id' => $listing->id,
                'title' => $listing->product_name,
                'slug' => $listing->slug,
                'url' => route('listing.details', $listing->slug),
                'thumbnail_url' => asset($listing->thumbnail),
                'price' => (float) $listing->price,
                'final_price' => (float) $listing->final_price,
                'currency_symbol' => setting('currency_symbol', 'global'),
                'discount' => $listing->discount_value > 0 ? [
                    'value' => (float) $listing->discount_value,
                    'type' => $listing->discount_type
                ] : null,
                'rating' => [
                    'average' => (float) $listing->avg_rating,
                    'count' => $listing->reviews()->count(),
                    'percentage' => round($listing->avg_rating * 20, 2)
                ],
                'badges' => [
                    'is_trending' => (bool) $listing->is_trending,
                    'is_flash' => (bool) $listing->is_flash,
                    'duration' => $listing->selected_duration,
                    'plan' => $listing->selected_plan ?? $listing->plan_id,
                    'delivery_method' => $listing->delivery_method == 'auto' ? 'Instant' : 'Manual',
                    'delivery_speed' => $listing->delivery_speed ? $listing->delivery_speed . ' ' . $listing->delivery_speed_unit : null,
                    'devices' => $listing->devices
                ],
                'seller' => [
                    'username' => $listing->seller->username,
                    'avatar' => asset($listing->seller->avatar_path ?? 'frontend/images/user/user-default.png'),
                    'is_verified' => (bool) $listing->seller->kyc == 1
                ],
                'category' => [
                    'name' => $listing->category->name,
                    'slug' => $listing->category->slug
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'current_page' => $listings->currentPage(),
                'last_page' => $listings->lastPage(),
                'per_page' => $listings->perPage(),
                'total' => $listings->total()
            ]
        ]);
    }
}
