<?php

namespace App\Http\Controllers\Backend;

use App\Enums\ListingStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    use ImageUpload;

    public function index(Request $request, $approved = null)
    {
        $perPage = $request->perPage ?? 15;
        $search = $request->search ?? null;
        $status = $request->status ?? 'all';
        $listings = Listing::search($search)
            ->when($request->approval, function ($query) use ($request) {
                if ($request->approval == 'approved') {
                    $query->where('is_approved', 1);
                } elseif ($request->approval == 'unapproved') {
                    $query->where('is_approved', 0);
                }
            })
        // category
            ->when($request->category != 'all' && ! empty($request->category), function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->status($status)
            ->latest()
            ->paginate($perPage);

        $categories = Category::get(['id', 'name']);

        return view('backend.listing.index', compact('listings', 'categories'));
    }

    public function listingDetails($id)
    {
        $listing = Listing::findOrFail($id);

        return view('backend.listing.details', compact('listing'));
    }

    public function destroy($id)
    {
        $listing = Listing::findOrFail($id);
        $this->delete($listing->thumbnail);
        foreach ($listing->images as $key => $image) {
            $this->delete($image->image_path);
        }
        $listing->deliveryItems()->delete();
        notify()->success(__('Listing deleted successfully!'));
        $listing->delete();

        return back();
    }

    public function approvalToggle($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->update(['is_approved' => ! $listing->is_approved, 'status' => ListingStatus::Active]);
        notify()->success(__('Listing approval status updated successfully!'));

        return back();
    }

    public function trendingToggle(Request $request, $id)
    {
        $category = Listing::findOrFail($id);
        $category->update(['is_trending' => ! $category->is_trending]);

        notify()->success(__('Listing trending status updated successfully!'));

        return back();
    }

    /**
     * Update the listing status
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function statusUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:'.implode(',', array_column(ListingStatus::cases(), 'value')),
        ]);

        $listing = Listing::findOrFail($id);
        $listing->update(['status' => $request->status]);

        notify()->success(__('Listing status updated successfully!'));

        return back();
    }
}
