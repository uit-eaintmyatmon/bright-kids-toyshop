@extends('layouts.app')

@section('title', 'Statuses - Admin')

@section('content')
<div class="container py-4">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-flag me-2"></i>Statuses</h2>
    <a href="{{ route('admin.statuses.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Status
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
                        <th>Color</th>
                        <th>Toys</th>
                        <th>Active</th>
                        <th>Order</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($statuses as $status)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-{{ $status->color }}">{{ $status->name }}</span>
                            </td>
                            <td><code>{{ $status->slug }}</code></td>
                            <td>
                                <span class="badge bg-{{ $status->color }}">{{ $status->color }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $status->toys_count }} toys</span>
                            </td>
                            <td>
                                @if($status->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $status->sort_order }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.statuses.edit', $status) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.statuses.destroy', $status) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this status?');">
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
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                No statuses found
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
