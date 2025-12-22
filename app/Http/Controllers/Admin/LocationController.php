<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::withCount('toys')->orderBy('sort_order')->orderBy('name')->paginate(15);
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:locations',
            'description' => 'nullable|max:500',
            'color' => 'required|max:20',
            'country' => 'nullable|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        Location::create($data);

        return redirect()->route('admin.locations.index')->with('success', 'Location created!');
    }

    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:locations,slug,' . $location->id,
            'description' => 'nullable|max:500',
            'color' => 'required|max:20',
            'country' => 'nullable|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $location->update($data);

        return redirect()->route('admin.locations.index')->with('success', 'Location updated!');
    }

    public function destroy(Location $location)
    {
        if ($location->toys()->count() > 0) {
            return back()->with('error', 'Cannot delete location with toys assigned.');
        }
        
        $location->delete();
        return redirect()->route('admin.locations.index')->with('success', 'Location deleted!');
    }
}
