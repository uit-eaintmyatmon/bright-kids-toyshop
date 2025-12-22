<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Status;
use App\Models\Toy;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Toy::with(['category', 'status', 'location', 'images'])->available();

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
            );
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        // Filter by location
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sortField = $request->get('sort', 'name');
        $sortDir = $request->get('dir', 'asc');
        $allowedSorts = ['name', 'price', 'created_at'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDir === 'desc' ? 'desc' : 'asc');
        }

        $toys = $query->paginate(12)->withQueryString();
        
        // Get filter options
        $categories = Category::active()->orderBy('sort_order')->orderBy('name')->get();
        $featuredCategories = Category::active()->featured()->orderBy('sort_order')->orderBy('name')->get();
        $statuses = Status::active()->orderBy('sort_order')->orderBy('name')->get();
        $locations = Location::active()->orderBy('sort_order')->orderBy('name')->get();

        return view('public.index', compact('toys', 'categories', 'featuredCategories', 'statuses', 'locations'));
    }

    public function show(Toy $toy)
    {
        $toy->load(['category', 'status', 'location', 'images']);
        return view('public.show', compact('toy'));
    }
}
