@extends('layouts.app')

@section('title', $toy->name . ' - Bright Kids')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('public.index') }}" class="text-decoration-none" style="color: #4A3728;">Home</a></li>
            <li class="breadcrumb-item active">{{ $toy->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-md-5">
            @if($toy->images->count() > 1)
                @php $imageUrls = $toy->images->pluck('image_url')->toArray(); @endphp
                <!-- Image Carousel for multiple images -->
                <div id="toyCarousel" class="carousel slide shadow rounded" data-bs-ride="false" style="border-radius: 15px; overflow: hidden;">
                    <div class="carousel-indicators">
                        @foreach($toy->images as $index => $image)
                            <button type="button" data-bs-target="#toyCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner rounded">
                        @foreach($toy->images as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                                <img src="{{ $image->image_url }}" class="d-block w-100" alt="{{ $toy->name }}" style="height: 400px; object-fit: cover; cursor: zoom-in;" 
                                     onclick="openGalleryModal(@js($imageUrls), {{ $index }})">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#toyCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#toyCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <!-- Thumbnails -->
                <div class="row g-2 mt-3">
                    @foreach($toy->images as $index => $image)
                        <div class="col-3">
                            <img src="{{ $image->image_url }}" 
                                 class="img-thumbnail {{ $index === 0 ? 'border-warning border-2' : '' }}" 
                                 alt="Thumbnail {{ $index + 1 }}" 
                                 style="height: 80px; width: 100%; object-fit: cover; cursor: pointer; border-radius: 10px;"
                                 onclick="document.querySelector('[data-bs-slide-to=\'{{ $index }}\']').click()">
                        </div>
                    @endforeach
                </div>
            @elseif($toy->images->count() === 1)
                <img src="{{ $toy->images->first()->image_url }}" class="img-fluid rounded shadow" alt="{{ $toy->name }}" style="cursor: zoom-in; border-radius: 15px;" onclick="openImageModal('{{ $toy->images->first()->image_url }}')">
            @elseif($toy->image_url)
                <img src="{{ $toy->image_url }}" class="img-fluid rounded shadow" alt="{{ $toy->name }}" style="cursor: zoom-in; border-radius: 15px;" onclick="openImageModal('{{ $toy->image_url }}')">
            @else
                <div class="bg-secondary rounded d-flex align-items-center justify-content-center shadow" style="height: 400px; border-radius: 15px;">
                    <i class="bi bi-puzzle text-white" style="font-size: 8rem;"></i>
                </div>
            @endif
        </div>
        <div class="col-md-7">
            @if($toy->category)
                <span class="badge category-badge mb-2">{{ $toy->category->name }}</span>
            @endif
            <h1 class="display-5 fw-bold" style="color: #4A3728;">{{ $toy->name }}</h1>
            <p class="text-muted mb-3"><i class="bi bi-upc me-1"></i>SKU: {{ $toy->sku }}</p>
            
            <div class="mb-4">
                @if($toy->status)
                    <span class="badge bg-{{ $toy->status->color ?? 'secondary' }} fs-6 me-2">{{ $toy->status->name }}</span>
                @endif
                @if($toy->location)
                    <span class="badge bg-{{ $toy->location->color ?? 'info' }} fs-6 me-2"><i class="bi bi-geo-alt me-1"></i>{{ $toy->location->name }}</span>
                @endif
            </div>

            <p class="lead text-muted">{{ $toy->description }}</p>

            <div class="card border-0 mb-4" style="background: linear-gradient(135deg, #FFF8E7 0%, #FFE4B5 100%); border-radius: 15px;">
                <div class="card-body py-4">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <h2 class="price-tag mb-0">{{ number_format($toy->price) }} Ks</h2>
                            <small class="text-muted">Price</small>
                        </div>
                        <div class="col-6">
                            <h2 class="mb-0 fw-bold" style="color: #4A3728;">{{ $toy->quantity }}</h2>
                            <small class="text-muted">In Stock</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('public.index') }}" class="btn btn-outline-dark">
                    <i class="bi bi-arrow-left me-1"></i>Back to Products
                </a>
                <a href="https://m.me/BrightKidsEducationalToysAndBooksMandalay?ref={{ $toy->sku }}" target="_blank" class="btn btn-bright">
                    <i class="bi bi-messenger me-1"></i>Inquire on Messenger
                </a>
                <a href="tel:09972888802" class="btn btn-success">
                    <i class="bi bi-telephone me-1"></i>Call to Order
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
