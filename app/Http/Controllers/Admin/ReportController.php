<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use App\Models\Status;
use App\Models\Toy;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $totals = [
            'total_items' => Toy::count(),
            'total_quantity' => Toy::sum('quantity'),
            'total_value' => Toy::sum(DB::raw('price * quantity')),
            'unique_skus' => Toy::distinct('sku')->count(),
        ];

        $byStatus = Status::withCount('toys')
            ->with(['toys' => fn($q) => $q->select('status_id', DB::raw('SUM(quantity) as total_qty'))->groupBy('status_id')])
            ->orderBy('toys_count', 'desc')
            ->get()
            ->map(fn($s) => [
                'name' => $s->name,
                'color' => $s->color,
                'count' => $s->toys_count,
                'quantity' => Toy::where('status_id', $s->id)->sum('quantity')
            ]);

        $byLocation = Location::withCount('toys')
            ->orderBy('toys_count', 'desc')
            ->get()
            ->map(fn($l) => [
                'name' => $l->name,
                'color' => $l->color,
                'count' => $l->toys_count,
                'quantity' => Toy::where('location_id', $l->id)->sum('quantity')
            ]);

        $byCategory = Category::withCount('toys')
            ->orderBy('toys_count', 'desc')
            ->get()
            ->map(fn($c) => [
                'name' => $c->name,
                'color' => $c->color,
                'count' => $c->toys_count,
                'quantity' => Toy::where('category_id', $c->id)->sum('quantity')
            ]);

        $lowStockItems = Toy::with(['category', 'status', 'location'])
            ->where('quantity', '>', 0)
            ->where('quantity', '<=', 10)
            ->orderBy('quantity')
            ->get();

        $outOfStockItems = Toy::with(['category', 'status', 'location'])
            ->where('quantity', '<=', 0)
            ->orderBy('name')
            ->get();

        return view('admin.reports', compact('totals', 'byStatus', 'byLocation', 'byCategory', 'lowStockItems', 'outOfStockItems'));
    }

    public function inventory()
    {
        $toys = Toy::with(['category', 'status', 'location'])->orderBy('name')->get();
        return view('admin.inventory', compact('toys'));
    }
}
