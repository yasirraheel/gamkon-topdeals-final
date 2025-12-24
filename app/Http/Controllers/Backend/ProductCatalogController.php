<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductCatalog;
use App\Models\SubscriptionPlan;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCatalogController extends Controller
{
    use ImageUpload;

    public function __construct()
    {
        $this->middleware('permission:product-catalog-list', ['only' => ['index']]);
        $this->middleware('permission:product-catalog-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-catalog-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-catalog-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $catalogs = ProductCatalog::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%'.$request->search.'%');
            })
            ->when($request->sort_field && $request->sort_dir, function ($query) use ($request) {
                $query->orderBy($request->sort_field, $request->sort_dir);
            }, function ($query) {
                $query->orderBy('order', 'asc');
            })
            ->paginate();

        return view('backend.product-catalog.index', compact('catalogs'));
    }

    public function create()
    {
        return view('backend.product-catalog.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:product_catalogs',
            'icon' => 'nullable|image|mimes:jpeg,jpg,png,svg|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'durations' => 'nullable|array',
            'durations.*' => 'nullable|string',
            'sharing_methods' => 'nullable|array',
            'sharing_methods.*' => 'nullable|string',
            'plans' => 'nullable|array',
            'plans.*' => 'nullable|string',
            'regions' => 'nullable|array',
            'regions.*' => 'nullable|string',
            'platforms' => 'nullable|array',
            'platforms.*' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'order' => 'nullable|numeric|unique:product_catalogs,order',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');
            return redirect()->back()->withInput();
        }

        $iconPath = null;
        $thumbnailPath = null;

        if ($request->hasFile('icon')) {
            $iconPath = $this->imageUploadTrait($request->file('icon'));
        }

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $this->imageUploadTrait($request->file('thumbnail'));
        }

        // Filter out empty values
        $durations = $request->get('durations') ? array_values(array_filter($request->get('durations'), function($value) {
            return !empty(trim($value));
        })) : null;
        
        $sharingMethods = $request->get('sharing_methods') ? array_values(array_filter($request->get('sharing_methods'), function($value) {
            return !empty(trim($value));
        })) : null;
        
        $plans = $request->get('plans') ? array_values(array_filter($request->get('plans'), function($value) {
            return !empty(trim($value));
        })) : null;

        $regions = $request->get('regions') ? array_values(array_filter($request->get('regions'), function($value) {
            return !empty(trim($value));
        })) : null;

        $platforms = $request->get('platforms') ? array_values(array_filter($request->get('platforms'), function($value) {
            return !empty(trim($value));
        })) : null;

        ProductCatalog::create([
            'name' => $request->get('name'),
            'icon' => $iconPath,
            'thumbnail' => $thumbnailPath,
            'durations' => $durations,
            'sharing_methods' => $sharingMethods,
            'plans' => $plans,
            'regions' => $regions,
            'platforms' => $platforms,
            'description' => $request->get('description'),
            'status' => $request->get('status'),
            'order' => !$request->order || empty($request->order) ? ProductCatalog::max('order') + 1 : $request->get('order'),
        ]);

        notify()->success(__('Product Catalog added successfully!'));

        return to_route('admin.product-catalog.index');
    }

    public function edit($id)
    {
        $catalog = ProductCatalog::findOrFail($id);

        return view('backend.product-catalog.edit', compact('catalog'));
    }

    public function update(Request $request, $id)
    {
        $catalog = ProductCatalog::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:product_catalogs,name,'.$catalog->id,
            'icon' => 'nullable|image|mimes:jpeg,jpg,png,svg|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'durations' => 'nullable|array',
            'durations.*' => 'nullable|string',
            'sharing_methods' => 'nullable|array',
            'sharing_methods.*' => 'nullable|string',
            'plans' => 'nullable|array',
            'plans.*' => 'nullable|string',
            'regions' => 'nullable|array',
            'regions.*' => 'nullable|string',
            'platforms' => 'nullable|array',
            'platforms.*' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'order' => 'nullable|numeric|unique:product_catalogs,order,'.$catalog->id,
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');
            return redirect()->back()->withInput();
        }

        $iconPath = $catalog->icon;
        $thumbnailPath = $catalog->thumbnail;

        if ($request->hasFile('icon')) {
            $iconPath = $this->imageUploadTrait($request->file('icon'), $catalog->icon);
        }

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $this->imageUploadTrait($request->file('thumbnail'), $catalog->thumbnail);
        }

        // Filter out empty values
        $durations = $request->get('durations') ? array_values(array_filter($request->get('durations'), function($value) {
            return !empty(trim($value));
        })) : null;
        
        $sharingMethods = $request->get('sharing_methods') ? array_values(array_filter($request->get('sharing_methods'), function($value) {
            return !empty(trim($value));
        })) : null;
        
        $plans = $request->get('plans') ? array_values(array_filter($request->get('plans'), function($value) {
            return !empty(trim($value));
        })) : null;

        $regions = $request->get('regions') ? array_values(array_filter($request->get('regions'), function($value) {
            return !empty(trim($value));
        })) : null;

        $platforms = $request->get('platforms') ? array_values(array_filter($request->get('platforms'), function($value) {
            return !empty(trim($value));
        })) : null;

        $catalog->update([
            'name' => $request->get('name'),
            'icon' => $iconPath,
            'thumbnail' => $thumbnailPath,
            'durations' => $durations,
            'sharing_methods' => $sharingMethods,
            'plans' => $plans,
            'regions' => $regions,
            'platforms' => $platforms,
            'description' => $request->get('description'),
            'status' => $request->get('status'),
            'order' => !$request->order || empty($request->order) ? ProductCatalog::max('order') + 1 : $request->get('order'),
        ]);

        notify()->success(__('Product Catalog updated successfully!'));

        return to_route('admin.product-catalog.index');
    }

    public function destroy($id)
    {
        $catalog = ProductCatalog::findOrFail($id);

        if ($catalog->icon) {
            $this->delete($catalog->icon);
        }

        if ($catalog->thumbnail) {
            $this->delete($catalog->thumbnail);
        }

        $catalog->delete();

        notify()->success(__('Product Catalog deleted successfully!'));

        return to_route('admin.product-catalog.index');
    }

    public function statusToggle(Request $request, $id)
    {
        $catalog = ProductCatalog::findOrFail($id);
        $catalog->update(['status' => !$catalog->status]);

        notify()->success(__('Product Catalog status updated successfully!'));

        return back();
    }

    public function getCatalogData($id)
    {
        $catalog = ProductCatalog::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'name' => $catalog->name,
                'durations' => $catalog->durations ?? [],
                'sharing_methods' => $catalog->sharing_methods ?? [],
                'plans' => $catalog->plans ?? [],
                'regions' => $catalog->regions ?? [],
                'platforms' => $catalog->platforms ?? [],
                'thumbnail' => $catalog->thumbnail ? asset($catalog->thumbnail) : null,
            ]
        ]);
    }
}
