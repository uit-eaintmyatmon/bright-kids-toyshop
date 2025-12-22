<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::withCount('toys')->orderBy('sort_order')->orderBy('name')->paginate(15);
        return view('admin.statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('admin.statuses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:statuses',
            'description' => 'nullable|max:500',
            'color' => 'required|max:20',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        Status::create($data);

        return redirect()->route('admin.statuses.index')->with('success', 'Status created!');
    }

    public function edit(Status $status)
    {
        return view('admin.statuses.edit', compact('status'));
    }

    public function update(Request $request, Status $status)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:statuses,slug,' . $status->id,
            'description' => 'nullable|max:500',
            'color' => 'required|max:20',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $status->update($data);

        return redirect()->route('admin.statuses.index')->with('success', 'Status updated!');
    }

    public function destroy(Status $status)
    {
        if ($status->toys()->count() > 0) {
            return back()->with('error', 'Cannot delete status with toys assigned.');
        }
        
        $status->delete();
        return redirect()->route('admin.statuses.index')->with('success', 'Status deleted!');
    }
}
