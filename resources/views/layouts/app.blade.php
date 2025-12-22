<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bright Kids - Educational Toys and Books')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bright-yellow: #FFD700;
            --bright-orange: #FFA500;
            --bright-gold: #F4C430;
            --dark-brown: #4A3728;
            --light-cream: #FFF8E7;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--light-cream);
        }
        
        .navbar-brand { 
            font-weight: 800; 
            font-size: 1.4rem;
        }
        .navbar-brand img {
            height: 45px;
            margin-right: 10px;
        }
        
        .bg-bright-yellow {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
        }
        
        .btn-bright {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            border: none;
            color: var(--dark-brown);
            font-weight: 700;
        }
        .btn-bright:hover {
            background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%);
            color: var(--dark-brown);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 165, 0, 0.4);
        }
        
        /* Quick Category Badges */
        .quick-category-badge {
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }
        .quick-category-badge:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15) !important;
            background: linear-gradient(135deg, #FFF8E7 0%, #FFFFFF 100%) !important;
            border-color: var(--dark-brown);
        }
        .quick-category-badge.active {
            background: linear-gradient(135deg, var(--dark-brown) 0%, #5A4738 100%) !important;
            color: white !important;
            border-color: var(--dark-brown);
            box-shadow: 0 4px 12px rgba(74, 55, 40, 0.3) !important;
        }
        .quick-category-badge.active i {
            color: var(--bright-yellow);
        }
        
        .toy-card { 
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .toy-card:hover { 
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .status-badge { font-size: 0.75rem; }
        
        .hero-section { 
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 50%, #FF8C00 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        /* Carousel styles for toy images */
        .toy-card .carousel-control-prev,
        .toy-card .carousel-control-next {
            width: 30px;
            background: rgba(0,0,0,0.3);
            border-radius: 4px;
            margin: 5px;
            height: 40px;
            top: 50%;
            transform: translateY(-50%);
        }
        .toy-card .carousel-indicators {
            margin-bottom: 5px;
        }
        .toy-card .carousel-indicators button {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        
        .category-badge {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            color: var(--dark-brown);
            font-weight: 600;
        }
        
        .price-tag {
            color: #e74c3c;
            font-weight: 800;
        }
        
        .footer-bright {
            background: linear-gradient(135deg, #4A3728 0%, #2C1810 100%);
        }
        
        .snowflake {
            position: absolute;
            color: white;
            opacity: 0.6;
            animation: fall linear infinite;
        }
        
        @keyframes fall {
            0% { transform: translateY(-10px) rotate(0deg); }
            100% { transform: translateY(100vh) rotate(360deg); }
        }
        
        .owl-mascot {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--dark-brown);
        }
        
        .social-link {
            width: 40px;
            height: 40px;
            background: var(--bright-yellow);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-brown);
            transition: all 0.3s ease;
        }
        .social-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.5);
            color: var(--dark-brown);
        }
        
        /* Custom Pagination Styling */
        .pagination {
            gap: 5px;
        }
        .pagination .page-item .page-link {
            border: none;
            border-radius: 10px;
            padding: 10px 16px;
            color: var(--dark-brown);
            font-weight: 600;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .pagination .page-item .page-link:hover {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            color: var(--dark-brown);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(255, 165, 0, 0.3);
        }
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            color: var(--dark-brown);
            box-shadow: 0 4px 15px rgba(255, 165, 0, 0.4);
        }
        .pagination .page-item.disabled .page-link {
            background: #f0f0f0;
            color: #aaa;
            box-shadow: none;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background: linear-gradient(135deg, #4A3728 0%, #2C1810 100%);">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('public.index') }}">
                <span class="owl-mascot me-2" style="width: 40px; height: 40px; font-size: 1.2rem;">🦉</span>
                <span>Bright Kids</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.index') }}">
                            <i class="bi bi-house me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://web.facebook.com/BrightKidsEducationalToysAndBooksMandalay" target="_blank">
                            <i class="bi bi-facebook me-1"></i>Facebook
                        </a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.toys.index') }}">
                                <i class="bi bi-box-seam me-1"></i>Toys
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-gear me-1"></i>Settings
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}"><i class="bi bi-tags me-2"></i>Categories</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.statuses.index') }}"><i class="bi bi-flag me-2"></i>Statuses</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.locations.index') }}"><i class="bi bi-geo-alt me-2"></i>Locations</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.users.index') }}"><i class="bi bi-people me-2"></i>Users</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.import.index') }}">
                                <i class="bi bi-upload me-1"></i>Import
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.reports.index') }}">
                                <i class="bi bi-graph-up me-1"></i>Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-white">
                                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.login') }}">
                                <i class="bi bi-gear me-1"></i>Admin
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="footer-bright text-white py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-3">
                        <span class="owl-mascot me-3" style="width: 50px; height: 50px; font-size: 1.5rem;">🦉</span>
                        <div>
                            <h5 class="mb-0 fw-bold">Bright Kids</h5>
                            <small class="text-warning">Educational Toys & Books</small>
                        </div>
                    </div>
                    <p class="text-white-50 small">ကလေးကစားစရာနှင့် ကလေးသင်ထောက်ကူ<br>Educational toys and book shop</p>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold text-warning mb-3"><i class="bi bi-geo-alt me-2"></i>Our Locations</h6>
                    <p class="small text-white-50 mb-2">
                        <strong class="text-white">Mandalay Branch</strong><br>
                        ၇၃လမ်း၊၃၄နှင့်၃၅လမ်းကြား၊<br>
                        ချမ်းအေးသာစံမြို့နယ်၊မန္တလေးမြို့
                    </p>
                    <p class="small text-white-50">
                        <i class="bi bi-telephone me-1"></i>09972888802, 09686877712
                    </p>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold text-warning mb-3"><i class="bi bi-link-45deg me-2"></i>Connect With Us</h6>
                    <div class="d-flex gap-2 mb-3">
                        <a href="https://web.facebook.com/BrightKidsEducationalToysAndBooksMandalay" target="_blank" class="social-link">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="tel:09972888802" class="social-link">
                            <i class="bi bi-telephone"></i>
                        </a>
                        <a href="https://m.me/BrightKidsEducationalToysAndBooksMandalay" target="_blank" class="social-link">
                            <i class="bi bi-messenger"></i>
                        </a>
                    </div>
                    <p class="small text-white-50">
                        Follow us on Facebook for latest products and promotions!
                    </p>
                </div>
            </div>
            <hr class="my-4 opacity-25">
            <div class="text-center text-white-50 small">
                <p class="mb-0">&copy; {{ date('Y') }} Bright Kids Educational Toys and Books Mandalay. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Fullscreen Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-centered">
            <div class="modal-content bg-dark bg-opacity-90">
                <div class="modal-header border-0 position-absolute top-0 end-0" style="z-index: 1;">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center p-0">
                    <img id="modalImage" src="" alt="Full size image" class="img-fluid" style="max-height: 95vh; max-width: 95vw; object-fit: contain;">
                </div>
                <!-- Navigation arrows for gallery -->
                <button class="btn btn-dark position-absolute start-0 top-50 translate-middle-y ms-2 d-none" id="modalPrev" style="opacity: 0.7;">
                    <i class="bi bi-chevron-left fs-3"></i>
                </button>
                <button class="btn btn-dark position-absolute end-0 top-50 translate-middle-y me-2 d-none" id="modalNext" style="opacity: 0.7;">
                    <i class="bi bi-chevron-right fs-3"></i>
                </button>
                <!-- Image counter -->
                <div class="position-absolute bottom-0 start-50 translate-middle-x mb-3 text-white d-none" id="modalCounter">
                    <span id="currentIndex">1</span> / <span id="totalImages">1</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fullscreen image modal functionality
        let currentImages = [];
        let currentImageIndex = 0;
        
        const imageModal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalPrev = document.getElementById('modalPrev');
        const modalNext = document.getElementById('modalNext');
        const modalCounter = document.getElementById('modalCounter');
        const currentIndexEl = document.getElementById('currentIndex');
        const totalImagesEl = document.getElementById('totalImages');

        // Open modal with single image
        function openImageModal(src) {
            currentImages = [src];
            currentImageIndex = 0;
            showCurrentImage();
            modalPrev.classList.add('d-none');
            modalNext.classList.add('d-none');
            modalCounter.classList.add('d-none');
            new bootstrap.Modal(imageModal).show();
        }

        // Open modal with gallery
        function openGalleryModal(images, startIndex = 0) {
            currentImages = images;
            currentImageIndex = startIndex;
            showCurrentImage();
            
            if (images.length > 1) {
                modalPrev.classList.remove('d-none');
                modalNext.classList.remove('d-none');
                modalCounter.classList.remove('d-none');
                totalImagesEl.textContent = images.length;
            } else {
                modalPrev.classList.add('d-none');
                modalNext.classList.add('d-none');
                modalCounter.classList.add('d-none');
            }
            new bootstrap.Modal(imageModal).show();
        }

        function showCurrentImage() {
            modalImage.src = currentImages[currentImageIndex];
            currentIndexEl.textContent = currentImageIndex + 1;
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % currentImages.length;
            showCurrentImage();
        }

        function prevImage() {
            currentImageIndex = (currentImageIndex - 1 + currentImages.length) % currentImages.length;
            showCurrentImage();
        }

        modalPrev?.addEventListener('click', prevImage);
        modalNext?.addEventListener('click', nextImage);

        // Keyboard navigation
        imageModal?.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === 'Escape') bootstrap.Modal.getInstance(imageModal)?.hide();
        });

        // Click on image to close (optional)
        modalImage?.addEventListener('click', function() {
            bootstrap.Modal.getInstance(imageModal)?.hide();
        });
    </script>
    @stack('scripts')
</body>
</html>
