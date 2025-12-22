@extends('layouts.app')

@section('title', 'Add Status - Admin')

@section('content')
<div class="container py-4">
<div class="mb-4">
    <a href="{{ route('admin.statuses.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back to Statuses
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-plus-lg me-2"></i>Add New Status</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.statuses.store') }}" method="POST">
            @csrf
            @include('admin.statuses._form')
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Create Status
                </button>
                <a href="{{ route('admin.statuses.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
