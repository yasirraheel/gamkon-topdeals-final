<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AccountPlan;
use App\Models\ProductCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:product-catalog-list', ['only' => ['index']]);
        $this->middleware('permission:product-catalog-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-catalog-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-catalog-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request, $catalogId)
    {
        $catalog = ProductCatalog::findOrFail($catalogId);
        $plans = AccountPlan::where('product_catalog_id', $catalogId)
            ->when($request->search, function ($query) use ($request) {
                $query->where('plan_name', 'LIKE', '%'.$request->search.'%');
            })
            ->when($request->sort_field && $request->sort_dir, function ($query) use ($request) {
                $query->orderBy($request->sort_field, $request->sort_dir);
            }, function ($query) {
                $query->orderBy('order', 'asc');
            })
            ->paginate();

        return view('backend.account-plans.index', compact('plans', 'catalog'));
    }

    public function create($catalogId)
    {
        $catalog = ProductCatalog::findOrFail($catalogId);
        return view('backend.account-plans.create', compact('catalog'));
    }

    public function store(Request $request, $catalogId)
    {
        $catalog = ProductCatalog::findOrFail($catalogId);

        $validator = Validator::make($request->all(), [
            'plan_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'order' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');
            return redirect()->back()->withInput();
        }

        AccountPlan::create([
            'product_catalog_id' => $catalogId,
            'plan_name' => $request->get('plan_name'),
            'description' => $request->get('description'),
            'status' => $request->get('status'),
            'order' => !$request->order || empty($request->order) 
                ? AccountPlan::where('product_catalog_id', $catalogId)->max('order') + 1 
                : $request->get('order'),
        ]);

        notify()->success(__('Account Plan added successfully!'));

        return to_route('admin.account-plans.index', $catalogId);
    }

    public function edit($catalogId, $id)
    {
        $catalog = ProductCatalog::findOrFail($catalogId);
        $plan = AccountPlan::where('product_catalog_id', $catalogId)->findOrFail($id);

        return view('backend.account-plans.edit', compact('catalog', 'plan'));
    }

    public function update(Request $request, $catalogId, $id)
    {
        $catalog = ProductCatalog::findOrFail($catalogId);
        $plan = AccountPlan::where('product_catalog_id', $catalogId)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'plan_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'order' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');
            return redirect()->back()->withInput();
        }

        $plan->update([
            'plan_name' => $request->get('plan_name'),
            'description' => $request->get('description'),
            'status' => $request->get('status'),
            'order' => !$request->order || empty($request->order) 
                ? AccountPlan::where('product_catalog_id', $catalogId)->max('order') + 1 
                : $request->get('order'),
        ]);

        notify()->success(__('Account Plan updated successfully!'));

        return to_route('admin.account-plans.index', $catalogId);
    }

    public function destroy($catalogId, $id)
    {
        $catalog = ProductCatalog::findOrFail($catalogId);
        $plan = AccountPlan::where('product_catalog_id', $catalogId)->findOrFail($id);

        $plan->delete();

        notify()->success(__('Account Plan deleted successfully!'));

        return to_route('admin.account-plans.index', $catalogId);
    }

    public function statusToggle(Request $request, $catalogId, $id)
    {
        $catalog = ProductCatalog::findOrFail($catalogId);
        $plan = AccountPlan::where('product_catalog_id', $catalogId)->findOrFail($id);
        
        $plan->update(['status' => !$plan->status]);

        notify()->success(__('Account Plan status updated successfully!'));

        return back();
    }
}
