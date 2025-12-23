<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingReview;
use App\Models\RecentSearch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class FrontendController extends Controller
{
    public function sellerDetails(Request $request, User $user)
    {
        $categories = Category::active()->get();
        $seller = $user;
        $listings = Listing::with('productCatalog')->public()->whereBelongsTo($user, 'seller')

            ->when($request->sort, function ($query) use ($request) {
                match ($request->sort) {
                    'max-to-min' => $query->latest('price'),
                    'min-to-max' => $query->oldest('price'),
                    'best-rated' => $query->withAvg('reviews', 'rating')->orderBy('avg_rating', 'desc'),
                    'trending' => $query->orderBy('is_trending', 'desc'),
                    default => $query->latest(),
                };
            })
            ->when($request->order, function ($query) use ($request) {
                match ($request->order) {
                    'newest' => $query->latest(),
                    'oldest' => $query->oldest(),
                    default => $query->latest(),
                };
            })
            ->when($request->min_price, function ($query) use ($request) {
                $query->where('price', '>=', $request->min_price);
            })
            ->when($request->max_price, function ($query) use ($request) {
                $query->where('price', '<=', $request->max_price);
            })
            ->paginate(12, ['*'], 'listings');

        return view('frontend::seller.details', compact('seller', 'listings'));
    }

    public function getAllCategoryListing(Request $request, ?Category $category = null)
    {

        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
        }

        $listings = Listing::with('productCatalog')->public()
            ->when($category, function ($query) use ($category, $request) {
                $column = match (true) {
                    $category->parent_id > 0 || $request->filled('category') => 'subcategory_id',
                    default => 'category_id',
                };
                $query->where($column, $category->id);
            })

            ->when($request->sort, function ($query) use ($request) {
                match ($request->sort) {
                    'max-to-min' => $query->latest('price'),
                    'min-to-max' => $query->oldest('price'),
                    'best-rated' => $query->withAvg('reviews', 'rating')->orderBy('avg_rating', 'desc'),
                    'trending' => $query->orderBy('is_trending', 'desc'),
                    'newest' => $query->latest(),
                    'oldest' => $query->oldest(),
                    'flash-sale' => $query->where('is_flash', 1)->latest('is_flash'),

                    default => $query->latest(),
                };
            })
            ->when($request->min_price, function ($query) use ($request) {
                $query->where('price', '>=', $request->min_price);
            })
            ->when($request->max_price, function ($query) use ($request) {
                $query->where('price', '<=', $request->max_price);
            })

            ->paginate($request->per_page ?? 12);

        $allCategories = Category::active()->isCategory()->get();

        $reqCat = $category;

        return view('frontend::category-listing', compact('listings', 'category', 'allCategories', 'reqCat'));
    }

    public function getAllCategory(Request $request)
    {
        $allCategories = Category::active()->isCategory()->withCount([
            'listings' => function ($query) {
                $query->public();
            },
        ])->get();

        return view('frontend::category', compact('allCategories'));
    }

    public function searchListing(Request $request)
    {
        $request->category = $request->category == 'all' ? null : $request->category;
        $listings = Listing::with('productCatalog')->public()
            ->when($request->q, function ($query) use ($request) {
                $query->search($request->q);
            })
            ->when($request->category, function ($query) use ($request) {
                $query->whereRelation('category', 'slug', $request->category);
            })
            ->when($request->min_price, function ($query) use ($request) {
                $query->where('price', '>=', $request->min_price);
            })
            ->when($request->max_price, function ($query) use ($request) {
                $query->where('price', '<=', $request->max_price);
            })
            ->when($request->sort, function ($query) use ($request) {
                match ($request->sort) {
                    'max-to-min' => $query->latest('price'),
                    'min-to-max' => $query->oldest('price'),
                    'best-rated' => $query->withAvg('reviews', 'rating')->orderBy('avg_rating', 'desc'),
                    'trending' => $query->orderBy('is_trending', 'desc'),
                    'newest' => $query->latest(),
                    'oldest' => $query->oldest(),
                    'flash-sale' => $query->where('is_flash', 1)->latest('is_flash'),
                    default => $query->latest(),
                };
            })
            ->paginate($request->per_page ?? 12);

        $allCategories = Category::active()->isCategory()->get();

        if ($request->q) {
            if (RecentSearch::where('query', $request->q)->where('user_id', auth()->id())->exists() == false) {
                RecentSearch::create(['query' => $request->q, 'user_id' => auth()->id(), 'count' => 1]);
            } else {
                RecentSearch::where('query', $request->q)->where('user_id', auth()->id())->increment('count');
            }

            if (!auth()->check()) {
                $searchedItems = session('searched', []);
                if (!in_array($request->q, $searchedItems)) {
                    $searchedItems[] = $request->q;
                }
                if (count($searchedItems) > 10) {
                    array_shift($searchedItems);
                }
                session(['searched' => $searchedItems], 60 * 24 * 30);
            }
        }

        return view('frontend::search', compact('listings', 'allCategories'));
    }

    public function removeRecentSearch(Request $request)
    {
        if (auth()->check()) {
            RecentSearch::where('query', $request->value)->where('user_id', auth()->id())->delete();
        } else {
            $searchedItems = session('searched', []);
            $searchedItems = array_diff($searchedItems, [$request->value]);
            session(['searched' => $searchedItems], 60 * 24 * 30);
        }

        return response()->json(['success' => true]);
    }

    public function acceptCookies(Request $request)
    {
        Cookie::queue(Cookie::make('gdpr_cookies', true, 60 * 24 * 365));

        return response()->json(['success' => true]);
    }

    public function rejectSignupFirstOrderBonus(Request $request)
    {
        Cookie::queue(Cookie::make('reject_signup_first_order_bonus', true, 60 * 24 * 365));

        return response()->json(['success' => true]);
    }

    public function followSeller(Request $request, User $user)
    {
        if (auth()->user()->id == $user->id) {
            return response()->json(['success' => false, 'message' => __('You can not follow yourself')]);
        }

        $user->followers()->toggle(auth()->user()->id);

        return response()->json(['success' => true, 'action' => $user->followers->contains(auth()->user()->id) ? 'added' : 'removed']);
    }

    public function allSellers(Request $request)
    {
        $sellers = User::where('user_type', 'seller')
            ->when($request->has('popular'), function ($query) {
                $query->orderBy('is_popular', 'desc');
            })
            ->when($request->has('filter-by'), function ($query) use ($request) {
                match ($request->input('filter-by')) {
                    default => $query,
                };
            })
            ->when($request->has('sort'), function ($query) use ($request) {
                match ($request->input('sort')) {
                    'newest' => $query->latest(),
                    'oldest' => $query->oldest(),
                    'popular' => $query->orderBy('is_popular', 'desc'),
                    'best-seller' => $query->orderBy('total_amount_sold', 'desc'),
                    'rated' => $query->orderBy('avg_rating', 'desc'),

                    default => $query,
                };
            })
            ->paginate(10);

        return view('frontend::all-sellers', compact('sellers'));
    }

    public function sellerReply(Request $request)
    {


        $request->validate([
            'review' => 'required|string|max:500',
        ]);

        $userId = auth()->id();

        $review = ListingReview::where('id', decrypt($request->reply_to))->whereNull('parent_id')->firstOrFail();
        abort_if($review?->listing?->seller_id != $userId, 403, __('You are not authorized to reply to this review.'));

        if (ListingReview::where('parent_id', $review->id)->exists()) {
            notify()->error(__('You have already replied to this review.'));
            return back();
        }

        ListingReview::create([
            'listing_id' => $review->listing_id,
            'order_id' => $review->order_id,
            'buyer_id' => $review->buyer_id,
            'seller_id' => $userId,
            'parent_id' => $review->id,
            'rating' => $review->rating,
            'review' => $request->review,
            'status' => \App\Enums\ListingReview::Approved,
            'reviewed_at' => now(),
        ]);


        notify()->success(__('Reply added successfully!'));

        return back();
    }

    public function sellerFlag(Request $request)
    {

        $request->validate([
            'flag_reason' => 'required|string|max:500',
        ]);

        $userId = auth()->id();
        $reviewId = decrypt($request->review_id);
        $review = ListingReview::where('id', $reviewId)->whereNull('parent_id')->where('seller_id', $userId)->firstOrFail();

        if ($review->status == \App\Enums\ListingReview::Flagged) {
            notify()->error(__('You have already flagged this review.'));
            return back();
        }
        $review->update([
            'status' => \App\Enums\ListingReview::Flagged,
            'flag_reason' => $request->reason,
        ]);

        notify()->success(__('Review flagged successfully!'));

        return back();
    }
}
