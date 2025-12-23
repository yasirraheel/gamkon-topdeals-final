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
            'durations.*' => 'string',
            'sharing_methods' => 'nullable|array',
            'sharing_methods.*' => 'string',
            'plans' => 'nullable|array',
            'plans.*' => 'exists:subscription_plans,id',
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

        ProductCatalog::create([
            'name' => $request->get('name'),
            'icon' => $iconPath,
            'thumbnail' => $thumbnailPath,
            'durations' => $request->get('durations'),
            'sharing_methods' => $request->get('sharing_methods'),
            'plans' => $request->get('plans'),
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
            'durations.*' => 'string',
            'sharing_methods' => 'nullable|array',
            'sharing_methods.*' => 'string',
            'plans' => 'nullable|array',
            'plans.*' => 'string',
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

        $catalog->update([
            'name' => $request->get('name'),
            'icon' => $iconPath,
            'thumbnail' => $thumbnailPath,
            'durations' => $request->get('durations'),
            'sharing_methods' => $request->get('sharing_methods'),
            'plans' => $request->get('plans'),
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
}
