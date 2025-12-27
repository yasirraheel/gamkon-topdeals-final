<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdUnit;
use Illuminate\Http\Request;

class AdUnitController extends Controller
{
    public function index()
    {
        $adUnits = AdUnit::latest()->paginate(10);
        return view('backend.ad_unit.index', compact('adUnits'));
    }

    public function create()
    {
        return view('backend.ad_unit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'code' => 'required|string',
            'is_active' => 'boolean',
        ]);

        AdUnit::create($request->all());

        return redirect()->route('admin.ad-units.index')->with('success', 'Ad Unit created successfully.');
    }

    public function edit(AdUnit $adUnit)
    {
        return view('backend.ad_unit.edit', compact('adUnit'));
    }

    public function update(Request $request, AdUnit $adUnit)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'code' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $adUnit->update($request->all());

        return redirect()->route('admin.ad-units.index')->with('success', 'Ad Unit updated successfully.');
    }

    public function destroy(AdUnit $adUnit)
    {
        $adUnit->delete();
        return redirect()->route('admin.ad-units.index')->with('success', 'Ad Unit deleted successfully.');
    }

    public function statusUpdate($id)
    {
        $adUnit = AdUnit::findOrFail($id);
        $adUnit->is_active = !$adUnit->is_active;
        $adUnit->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }

    public function updateSettings(Request $request)
    {
        // No validation needed for code snippets as they can be anything or empty
        \App\Models\Setting::add('ads_head_code', $request->ads_head_code);
        \App\Models\Setting::add('ads_body_code', $request->ads_body_code);

        return back()->with('success', 'Global ad settings updated successfully.');
    }
}
