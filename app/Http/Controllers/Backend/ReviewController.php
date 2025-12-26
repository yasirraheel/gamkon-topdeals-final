<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingReview;
use App\Models\User;
use App\Traits\NotifyTrait;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use NotifyTrait;
    public function __construct()
    {
        $this->middleware('can:listing-edit');
    }

    public function create()
    {
        $listings = Listing::where('status', 'active')->get(['id', 'product_name', 'seller_id']);
        $buyers = User::where('status', 1)->get(['id', 'username', 'first_name', 'last_name']);
        return view('backend.reviews.create', compact('listings', 'buyers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'buyer_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        $listing = Listing::findOrFail($request->listing_id);

        $review = ListingReview::create([
            'listing_id' => $listing->id,
            'seller_id' => $listing->seller_id,
            'buyer_id' => $request->buyer_id,
            'rating' => $request->rating,
            'review' => $request->review,
            'status' => 'approved',
            'reviewed_at' => now(),
        ]);

        $listing->increment('sold_count');

        $this->listingReviewUpdate($listing, $review, false);

        notify()->success(__('Review added successfully.'));

        return redirect()->route('admin.reviews.index');
    }

    public function index(Request $request)
    {
        $query = ListingReview::with(['listing', 'buyer', 'seller', 'order'])
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled('rating') and $request->rating != 'all', function ($q) use ($request) {
                $q->where('rating', $request->rating);
            })->when($request->filled('search'), function ($q) use ($request) {
                $q->whereHas('listing', function ($q) use ($request) {
                    $q->where('product_name', 'like', "%{$request->search}%");
                })->orWhereHas('buyer', function ($q) use ($request) {
                    $q->where('username', 'like', "%{$request->search}%");
                })->orWhere('review', 'like', "%{$request->search}%");
            })
            ->when($request->filled('sort_field'), function ($q) use ($request) {
                $q->orderBy($request->sort_field, $request->sort_dir ?? 'asc');
            });

        $reviews = $query->latest()->paginate(20);

        return view('backend.reviews.index', compact('reviews'));
    }

    public function show(ListingReview $review)
    {
        $review->load(['listing', 'buyer', 'seller', 'order']);

        return view('backend.reviews.show', compact('review'));
    }

    public function approve(ListingReview $review)
    {
        $oldStatus = $review->status;

        $review->update([
            'status' => 'approved',
            'reviewed_at' => now(),
        ]);

        $this->listingReviewUpdate($review->listing, $review, $oldStatus == \App\Enums\ListingReview::Pending);

        notify()->success(__('Review approved successfully.'));

        return back();
    }

    public function reject(Request $request, ListingReview $review)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $review->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
        ]);

        $this->listingReviewUpdate($review->listing, $review, false);

        notify()->success(__('Review rejected successfully.'));

        return back();
    }

    public function listingReviewUpdate(Listing $listing, ListingReview $review = null, $sendMail = true)
    {
        $avgRating = $listing->approvedReviews()->avg('rating');
        $avgRating = is_null($avgRating) ? 0 : $avgRating;
        $listing->update(['avg_rating' => $avgRating]);

        // seller avg_review total_reviews
        $seller = $listing->seller;

        $sellerAvgRating = ListingReview::where('seller_id', $seller->id)->approved()->avg('rating');
        $sellerAvgRating = is_null($sellerAvgRating) ? 0 : $sellerAvgRating;

        $sellerUpdatedData = [
            'avg_rating' => $sellerAvgRating,
            'total_reviews' => ListingReview::where('seller_id', $seller->id)->approved()->count(),
        ];

        $seller->update($sellerUpdatedData);

        // send notification to seller

        if ($sendMail) {
            $this->mailNotify($seller->email, 'seller_review_received', [
                '[[seller_name]]' => $seller->name,
                '[[buyer_name]]' => $review->buyer->full_name,
                '[[rating]]' => $review->rating,
                '[[listing_title]]' => $listing->product_name,
                '[[review]]' => $review->review,
                '[[order_number]]' => $review->order->order_number,
                '[[listing_url]]' => route('listing.details', $listing->slug),
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_link]]' => route('home'),
            ]);
        }

    }

    public function destroy(ListingReview $review)
    {
        $review->delete();

        notify()->success('Review deleted successfully.');

        return back();
    }

    public function recalculate()
    {
        $sellers = User::whereHas('listings')->get();
        foreach ($sellers as $seller) {
            $avg = ListingReview::where('seller_id', $seller->id)->approved()->avg('rating');
            $count = ListingReview::where('seller_id', $seller->id)->approved()->count();
            $seller->update([
                'avg_rating' => $avg ?? 0,
                'total_reviews' => $count
            ]);
        }
        notify()->success('Seller ratings recalculated successfully.');
        return back();
    }
}
