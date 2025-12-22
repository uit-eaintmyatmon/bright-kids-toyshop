@extends('layouts.app')

@section('title', 'Reports - Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-graph-up me-2"></i>Reports Dashboard</h1>
        <a href="{{ route('admin.reports.inventory') }}" class="btn btn-outline-primary">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i>Full Inventory
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Total Items</h6>
                            <h2 class="mb-0">{{ number_format($totals['total_items']) }}</h2>
                        </div>
                        <i class="bi bi-box-seam fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Total Quantity</h6>
                            <h2 class="mb-0">{{ number_format($totals['total_quantity']) }}</h2>
                        </div>
                        <i class="bi bi-stack fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Inventory Value</h6>
                            <h2 class="mb-0">${{ number_format($totals['total_value'], 2) }}</h2>
                        </div>
                        <i class="bi bi-currency-dollar fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Unique SKUs</h6>
                            <h2 class="mb-0">{{ number_format($totals['unique_skus']) }}</h2>
                        </div>
                        <i class="bi bi-upc-scan fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- By Status -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pie-chart me-2"></i>By Status</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th class="text-end">Items</th>
                                <th class="text-end">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($byStatus as $item)
                                <tr>
                                    <td>
                                        <span class="badge bg-{{ $item['color'] ?? 'secondary' }}">{{ $item['name'] }}</span>
                                    </td>
                                    <td class="text-end">{{ $item['count'] }}</td>
                                    <td class="text-end">{{ number_format($item['quantity']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- By Location -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>By Location</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Location</th>
                                <th class="text-end">Items</th>
                                <th class="text-end">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($byLocation as $item)
                                <tr>
                                    <td><span class="badge bg-{{ $item['color'] ?? 'info' }}">{{ $item['name'] }}</span></td>
                                    <td class="text-end">{{ $item['count'] }}</td>
                                    <td class="text-end">{{ number_format($item['quantity']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- By Category -->
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-tags me-2"></i>By Category</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($byCategory as $item)
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body text-center">
                                        <span class="badge bg-{{ $item['color'] ?? 'secondary' }} mb-2">{{ $item['name'] }}</span>
                                        <div class="h4 mb-0">{{ $item['count'] }} items</div>
                                        <small class="text-muted">{{ number_format($item['quantity']) }} units</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100 border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Low Stock Items (≤10)</h5>
                </div>
                <div class="card-body">
                    @if($lowStockItems->isEmpty())
                        <p class="text-muted text-center mb-0">No low stock items</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>SKU</th>
                                        <th class="text-end">Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockItems as $toy)
                                        <tr>
                                            <td>{{ $toy->name }}</td>
                                            <td><code>{{ $toy->sku }}</code></td>
                                            <td class="text-end text-warning fw-bold">{{ $toy->quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Out of Stock Items -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100 border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-x-circle me-2"></i>Out of Stock Items</h5>
                </div>
                <div class="card-body">
                    @if($outOfStockItems->isEmpty())
                        <p class="text-muted text-center mb-0">No out of stock items</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>SKU</th>
                                        <th>Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($outOfStockItems as $toy)
                                        <tr>
                                            <td>{{ $toy->name }}</td>
                                            <td><code>{{ $toy->sku }}</code></td>
                                            <td>{{ $toy->location?->name ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
