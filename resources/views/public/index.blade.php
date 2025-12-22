@extends('layouts.app')

@section('title', 'Bright Kids - Educational Toys and Books Mandalay')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-dark py-5 position-relative">
    <div class="container position-relative" style="z-index: 1;">
        <div class="row align-items-center">
            <div class="col-lg-7 text-center text-lg-start">
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start mb-3">
                    <span class="owl-mascot me-3">🦉</span>
                    <div>
                        <h1 class="display-4 fw-bold mb-0" style="color: #4A3728;">Bright Kids</h1>
                        <p class="lead mb-0 fw-semibold" style="color: #4A3728;">Educational Toys & Books</p>
                    </div>
                </div>
                <p class="fs-5 mb-2" style="color: #4A3728;">ကလေးကစားစရာနှင့် ကလေးသင်ထောက်ကူ</p>
                <p class="mb-4" style="color: #5A4738;">Discover our amazing collection of educational toys and books for children of all ages. Quality products to help your kids learn while having fun!</p>
                
                <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-lg-start mb-4">
                    @forelse($featuredCategories as $featCat)
                        <a href="{{ route('public.index', ['category_id' => $featCat->id]) }}#products" 
                           class="badge bg-white text-dark px-3 py-2 shadow-sm text-decoration-none quick-category-badge {{ request('category_id') == $featCat->id ? 'active' : '' }}">
                            @if($featCat->icon)
                                <i class="bi {{ $featCat->icon }} me-1"></i>
                            @endif
                            {{ $featCat->name }}
                        </a>
                    @empty
                        <span class="badge bg-white text-dark px-3 py-2 shadow-sm"><i class="bi bi-puzzle me-1"></i>Educational Toys</span>
                        <span class="badge bg-white text-dark px-3 py-2 shadow-sm"><i class="bi bi-book me-1"></i>Children Books</span>
                        <span class="badge bg-white text-dark px-3 py-2 shadow-sm"><i class="bi bi-lightbulb me-1"></i>Learning Materials</span>
                        <span class="badge bg-white text-dark px-3 py-2 shadow-sm"><i class="bi bi-gift me-1"></i>Gifts</span>
                    @endforelse
                </div>
                
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                    <a href="https://web.facebook.com/BrightKidsEducationalToysAndBooksMandalay" target="_blank" class="btn btn-dark btn-lg px-4">
                        <i class="bi bi-facebook me-2"></i>Visit Our Page
                    </a>
                    <a href="tel:09972888802" class="btn btn-outline-dark btn-lg px-4">
                        <i class="bi bi-telephone me-2"></i>Call Us
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                <div class="position-relative">
                    <div class="owl-mascot mx-auto" style="width: 200px; height: 200px; font-size: 6rem;">
                        🦉
                    </div>
                    <div class="position-absolute" style="top: -20px; right: 20px; font-size: 3rem;">🎄</div>
                    <div class="position-absolute" style="bottom: 20px; left: 0; font-size: 2rem;">🎁</div>
                    <div class="position-absolute" style="bottom: -10px; right: 40px; font-size: 2rem;">📚</div>
                    <div class="position-absolute" style="top: 30px; left: 20px; font-size: 2rem;">🧸</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Decorative snowflakes for Christmas -->
    @for($i = 0; $i < 15; $i++)
    <div class="snowflake" style="left: {{ rand(0, 100) }}%; animation-duration: {{ rand(5, 15) }}s; animation-delay: {{ rand(0, 5) }}s; font-size: {{ rand(10, 20) }}px;">❄</div>
    @endfor
</section>

<!-- Features Section -->
<section class="py-4 bg-white">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <div class="feature-icon mx-auto mb-2">
                    <i class="bi bi-truck"></i>
                </div>
                <h6 class="fw-bold">Fast Delivery</h6>
                <small class="text-muted">မြန်ဆန်သောပို့ဆောင်မှု</small>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-icon mx-auto mb-2">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h6 class="fw-bold">Quality Products</h6>
                <small class="text-muted">အရည်အသွေးမြင့်ပစ္စည်းများ</small>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-icon mx-auto mb-2">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <h6 class="fw-bold">Best Prices</h6>
                <small class="text-muted">သင့်တင့်သောဈေးနှုန်း</small>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-icon mx-auto mb-2">
                    <i class="bi bi-headset"></i>
                </div>
                <h6 class="fw-bold">Support</h6>
                <small class="text-muted">ဝန်ဆောင်မှုကောင်းမွန်</small>
            </div>
        </div>
    </div>
</section>

<div class="container py-4" id="products">
    <!-- Search & Filters -->
    <div class="card shadow-sm mb-4 border-0" style="border-radius: 15px;">
        <div class="card-body">
            <form method="GET" action="{{ route('public.index') }}">
                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-text bg-warning border-warning"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Search toys & books..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="col-6 col-md-3 col-lg-2">
                        <select name="category_id" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-6 col-md-3 col-lg-2">
                        <select name="status_id" class="form-select">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location -->
                    <div class="col-6 col-md-3 col-lg-2">
                        <select name="location_id" class="form-select">
                            <option value="">All Locations</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div class="col-6 col-md-3 col-lg-2">
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="name" {{ request('sort', 'name') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                            <option value="name" data-dir="desc" {{ request('sort') == 'name' && request('dir') == 'desc' ? 'selected' : '' }}>Name Z-A</option>
                            <option value="price" {{ request('sort') == 'price' && request('dir') != 'desc' ? 'selected' : '' }}>Price: Low-High</option>
                            <option value="price" data-dir="desc" {{ request('sort') == 'price' && request('dir') == 'desc' ? 'selected' : '' }}>Price: High-Low</option>
                            <option value="created_at" data-dir="desc" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest First</option>
                        </select>
                    </div>
                </div>

                <!-- Price Range (collapsible) -->
                <div class="row g-3 mt-2">
                    <div class="col-6 col-md-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Ks</span>
                            <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price') }}" min="0" step="0.01">
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Ks</span>
                            <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price') }}" min="0" step="0.01">
                        </div>
                    </div>
                    <div class="col-12 col-md-8 d-flex gap-2 justify-content-md-end">
                        <button type="submit" class="btn btn-bright btn-sm">
                            <i class="bi bi-funnel me-1"></i>Apply Filters
                        </button>
                        <a href="{{ route('public.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-x-lg me-1"></i>Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0 fw-bold" style="color: #4A3728;"><i class="bi bi-grid me-2"></i>Our Products</h2>
            <small class="text-muted">
                Showing {{ $toys->firstItem() ?? 0 }} - {{ $toys->lastItem() ?? 0 }} of {{ $toys->total() }} items
            </small>
        </div>
        @if(request()->hasAny(['search', 'category_id', 'status_id', 'location_id', 'min_price', 'max_price']))
            <span class="badge bg-warning text-dark"><i class="bi bi-funnel me-1"></i>Filters Active</span>
        @endif
    </div>

    @if($toys->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-2"></i>No toys found matching your criteria.
            <br>
            <a href="{{ route('public.index') }}" class="btn btn-link">Clear filters and show all toys</a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
            @foreach($toys as $toy)
                <div class="col">
                    <div class="card h-100 toy-card shadow-sm">
                        @if($toy->images->count() > 1)
                            @php $imageUrls = $toy->images->pluck('image_url')->toArray(); @endphp
                            <!-- Image Carousel for multiple images -->
                            <div id="carousel-{{ $toy->id }}" class="carousel slide" data-bs-ride="false" data-images="{{ json_encode($imageUrls) }}">
                                <div class="carousel-indicators">
                                    @foreach($toy->images as $index => $image)
                                        <button type="button" data-bs-target="#carousel-{{ $toy->id }}" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"></button>
                                    @endforeach
                                </div>
                                <div class="carousel-inner" style="cursor: zoom-in;">
                                    @foreach($toy->images as $index => $image)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                                            <img src="{{ $image->image_url }}" class="d-block w-100 gallery-image" alt="{{ $toy->name }}" style="height: 200px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $toy->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $toy->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        @elseif($toy->images->count() === 1)
                            <img src="{{ $toy->images->first()->image_url }}" class="card-img-top clickable-image" alt="{{ $toy->name }}" style="height: 200px; object-fit: cover; cursor: zoom-in;">
                        @elseif($toy->image_url)
                            <img src="{{ $toy->image_url }}" class="card-img-top clickable-image" alt="{{ $toy->name }}" style="height: 200px; object-fit: cover; cursor: zoom-in;">
                        @else
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-puzzle text-white" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            @if($toy->category)
                                <span class="badge category-badge mb-2">{{ $toy->category->name }}</span>
                            @endif
                            <h5 class="card-title fw-bold">{{ $toy->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($toy->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 price-tag mb-0">{{ number_format($toy->price) }} Ks</span>
                                @if($toy->status)
                                    <span class="badge bg-{{ $toy->status->color ?? 'secondary' }} status-badge">{{ $toy->status->name }}</span>
                                @else
                                    <span class="badge bg-secondary status-badge">Unknown</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0 pt-0">
                            <a href="{{ route('public.show', $toy) }}" class="btn btn-bright btn-sm w-100">
                                <i class="bi bi-eye me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($toys->hasPages())
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Product pagination">
                    {{ $toys->links() }}
                </nav>
            </div>
        @endif
    @endif
</div>

<!-- Call to Action -->
<section class="py-5 bg-white">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3" style="color: #4A3728;">ဆက်သွယ်ရန် / Contact Us</h3>
                <p class="text-muted mb-4">Have questions about our products? Want to place an order? Contact us through Facebook or give us a call!</p>
                <div class="d-flex flex-wrap gap-3 justify-content-center">
                    <a href="https://m.me/BrightKidsEducationalToysAndBooksMandalay" target="_blank" class="btn btn-bright btn-lg">
                        <i class="bi bi-messenger me-2"></i>Message Us
                    </a>
                    <a href="tel:09972888802" class="btn btn-outline-dark btn-lg">
                        <i class="bi bi-telephone me-2"></i>09972888802
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle single image clicks
    document.querySelectorAll('.clickable-image').forEach(img => {
        img.addEventListener('click', function() {
            openImageModal(this.src);
        });
    });

    // Handle gallery image clicks
    document.querySelectorAll('.gallery-image').forEach(img => {
        img.addEventListener('click', function(e) {
            const carousel = this.closest('.carousel');
            const images = JSON.parse(carousel.dataset.images);
            const activeItem = carousel.querySelector('.carousel-item.active');
            const index = parseInt(activeItem.dataset.index) || 0;
            openGalleryModal(images, index);
        });
    });
});
</script>
@endpush
