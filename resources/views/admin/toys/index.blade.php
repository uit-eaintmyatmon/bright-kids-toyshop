@extends('layouts.app')

@section('title', 'Manage Toys - Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-box-seam me-2"></i>Manage Toys</h1>
        <a href="{{ route('admin.toys.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Add New Toy
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Search & Filters</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.toys.index') }}" id="filterForm">
                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label small text-muted">Search</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Name, SKU, Description..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="col-md-6 col-lg-2">
                        <label class="form-label small text-muted">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 col-lg-2">
                        <label class="form-label small text-muted">Status</label>
                        <select name="status_id" class="form-select">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location -->
                    <div class="col-md-6 col-lg-2">
                        <label class="form-label small text-muted">Location</label>
                        <select name="location_id" class="form-select">
                            <option value="">All Locations</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Stock Filter -->
                    <div class="col-md-6 col-lg-2">
                        <label class="form-label small text-muted">Stock Level</label>
                        <select name="stock" class="form-select">
                            <option value="">All Stock</option>
                            <option value="in_stock" {{ request('stock') == 'in_stock' ? 'selected' : '' }}>In Stock (>10)</option>
                            <option value="low_stock" {{ request('stock') == 'low_stock' ? 'selected' : '' }}>Low Stock (1-10)</option>
                            <option value="out_of_stock" {{ request('stock') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="col-6 col-md-3 col-lg-2">
                        <label class="form-label small text-muted">Min Price</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="min_price" class="form-control" placeholder="0" value="{{ request('min_price') }}" min="0" step="0.01">
                        </div>
                    </div>

                    <div class="col-6 col-md-3 col-lg-2">
                        <label class="form-label small text-muted">Max Price</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="max_price" class="form-control" placeholder="Any" value="{{ request('max_price') }}" min="0" step="0.01">
                        </div>
                    </div>

                    <!-- Sort -->
                    <div class="col-6 col-md-3 col-lg-2">
                        <label class="form-label small text-muted">Sort By</label>
                        <select name="sort" class="form-select">
                            <option value="name" {{ request('sort', 'name') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="sku" {{ request('sort') == 'sku' ? 'selected' : '' }}>SKU</option>
                            <option value="category" {{ request('sort') == 'category' ? 'selected' : '' }}>Category</option>
                            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                            <option value="quantity" {{ request('sort') == 'quantity' ? 'selected' : '' }}>Quantity</option>
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date Added</option>
                        </select>
                    </div>

                    <div class="col-6 col-md-3 col-lg-2">
                        <label class="form-label small text-muted">Order</label>
                        <select name="dir" class="form-select">
                            <option value="asc" {{ request('dir', 'asc') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('dir') == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>Apply Filters
                        </button>
                        <a href="{{ route('admin.toys.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-1"></i>Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Summary -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">
            Showing {{ $toys->firstItem() ?? 0 }} - {{ $toys->lastItem() ?? 0 }} of {{ $toys->total() }} toys
        </span>
        @if(request()->hasAny(['search', 'category_id', 'status_id', 'location_id', 'stock', 'min_price', 'max_price']))
            <span class="badge bg-info">Filters Active</span>
        @endif
    </div>

    <!-- Toys Table -->
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">Image</th>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th class="text-end" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($toys as $toy)
                        <tr>
                            <td>
                                @if($toy->images->count() > 0)
                                    <div class="position-relative">
                                        <img src="{{ $toy->images->first()->image_url }}" alt="{{ $toy->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        @if($toy->images->count() > 1)
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary" style="font-size: 0.6rem;">
                                                +{{ $toy->images->count() - 1 }}
                                            </span>
                                        @endif
                                    </div>
                                @elseif($toy->image_url)
                                    <img src="{{ $toy->image_url }}" alt="{{ $toy->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-puzzle text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-medium">{{ $toy->name }}</td>
                            <td><code>{{ $toy->sku }}</code></td>
                            <td>
                                @if($toy->category)
                                    <span class="badge bg-{{ $toy->category->color ?? 'secondary' }}">{{ $toy->category->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>${{ number_format($toy->price, 2) }}</td>
                            <td>
                                @if($toy->quantity <= 0)
                                    <span class="text-danger fw-bold">{{ $toy->quantity }}</span>
                                @elseif($toy->quantity <= 10)
                                    <span class="text-warning fw-bold">{{ $toy->quantity }}</span>
                                @else
                                    <span class="text-success">{{ $toy->quantity }}</span>
                                @endif
                            </td>
                            <td>
                                @if($toy->status)
                                    <span class="badge bg-{{ $toy->status->color ?? 'secondary' }}">{{ $toy->status->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($toy->location)
                                    <span class="badge bg-{{ $toy->location->color ?? 'secondary' }}">{{ $toy->location->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" title="Quick Status">
                                        <i class="bi bi-lightning"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><h6 class="dropdown-header">Quick Status Change</h6></li>
                                        @foreach($statuses as $status)
                                            <li>
                                                <form action="{{ route('admin.toys.updateStatus', $toy) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status_id" value="{{ $status->id }}">
                                                    <button type="submit" class="dropdown-item {{ $toy->status_id == $status->id ? 'active' : '' }}">
                                                        <span class="badge bg-{{ $status->color }} me-1">&nbsp;</span> {{ $status->name }}
                                                    </button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="{{ route('admin.toys.edit', $toy) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.toys.destroy', $toy) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this toy?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No toys found matching your criteria.
                                <br>
                                <a href="{{ route('admin.toys.index') }}" class="btn btn-link">Clear filters</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($toys->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $toys->links() }}
        </div>
    @endif
</div>
@endsection
