@extends('layouts.app')

@section('title', 'Locations - Admin')

@section('content')
<div class="container py-4">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-geo-alt me-2"></i>Locations</h2>
    <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Location
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Country</th>
                        <th>Color</th>
                        <th>Toys</th>
                        <th>Active</th>
                        <th>Order</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $location)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-{{ $location->color }}">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $location->name }}
                                </span>
                            </td>
                            <td><code>{{ $location->slug }}</code></td>
                            <td>{{ $location->country ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $location->color }}">{{ $location->color }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $location->toys_count }} toys</span>
                            </td>
                            <td>
                                @if($location->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $location->sort_order }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this location?');">
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
                            <td colspan="9" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                No locations found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection
