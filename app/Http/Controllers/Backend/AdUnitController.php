<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdUnit;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        notify()->success('Ad Unit created successfully.');
        return redirect()->route('admin.ad-units.index');
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

        notify()->success('Ad Unit updated successfully.');
        return redirect()->route('admin.ad-units.index');
    }

    public function destroy(AdUnit $adUnit)
    {
        $adUnit->delete();
        notify()->success('Ad Unit deleted successfully.');
        return redirect()->route('admin.ad-units.index');
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
        // Use DB facade to ensure data is written directly to the database, bypassing any model issues
        $settings = [
            'ads_head_code' => $request->input('ads_head_code', ''),
            'ads_body_code' => $request->input('ads_body_code', ''),
        ];

        foreach ($settings as $key => $value) {
            // Ensure value is not null
            if (is_null($value)) {
                $value = '';
            }

            // Check if record exists
            $exists = DB::table('settings')->where('name', $key)->exists();

            if ($exists) {
                DB::table('settings')->where('name', $key)->update([
                    'val' => $value,
                    'type' => 'string',
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('settings')->insert([
                    'name' => $key,
                    'val' => $value,
                    'type' => 'string',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Manually flush the cache to ensure other parts of the app see the new values
        \App\Models\Setting::flushCache();

        notify()->success('Global ad settings updated successfully.');
        return back();
    }
}
