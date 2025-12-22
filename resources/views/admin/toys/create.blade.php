@extends('layouts.app')

@section('title', 'Add New Toy - Admin')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.toys.index') }}">Toys</a></li>
            <li class="breadcrumb-item active">Add New</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-plus-lg me-2"></i>Add New Toy</h5>
                </div>
                <div class="card-body">
                    @include('admin.toys._form', ['toy' => null, 'action' => route('admin.toys.store'), 'method' => 'POST'])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
