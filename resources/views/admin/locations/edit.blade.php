@extends('layouts.app')

@section('title', 'Edit Location - Admin')

@section('content')
<div class="container py-4">
<div class="mb-4">
    <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back to Locations
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Location: {{ $location->name }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.locations.update', $location) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.locations._form')
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Update Location
                </button>
                <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
