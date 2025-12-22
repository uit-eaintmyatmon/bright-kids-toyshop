@extends('layouts.app')

@section('title', 'Edit ' . $toy->name . ' - Admin')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.toys.index') }}">Toys</a></li>
            <li class="breadcrumb-item active">Edit: {{ $toy->name }}</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Toy</h5>
                </div>
                <div class="card-body">
                    @include('admin.toys._form', ['toy' => $toy, 'action' => route('admin.toys.update', $toy), 'method' => 'PUT'])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
