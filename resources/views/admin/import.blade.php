@extends('layouts.app')

@section('title', 'Import Toys - Admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4"><i class="bi bi-upload me-2"></i>Import Toys</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-code me-2"></i>Import from JSON</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.import.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="json" class="form-label">JSON Data</label>
                            <textarea class="form-control font-monospace" id="json" name="json" rows="15" placeholder="Paste your JSON array here...">{{ old('json') }}</textarea>
                            <div class="form-text">Paste a JSON array of toy objects. Existing toys with matching SKU will be updated.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-1"></i>Import Toys
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>JSON Format</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Your JSON should be an array of objects with these fields:</p>
                    <pre class="bg-light p-3 rounded small"><code>[
  {
    "name": "Teddy Bear",
    "sku": "TEDDY001",
    "description": "Soft plush teddy bear",
    "price": 24.99,
    "quantity": 50,
    "category": "dolls",
    "status": "in-stock",
    "location": "warehouse",
    "images": [
      "https://example.com/img1.jpg",
      "https://example.com/img2.jpg"
    ]
  },
  {
    "name": "Robot Toy",
    "sku": "ROBOT001",
    "description": "Walking robot toy",
    "price": 39.99,
    "quantity": 0,
    "category": "electronics",
    "status": "in-china",
    "location": "china",
    "images": [
      "data:image/png;base64,...",
      {"base64": "..."}
    ]
  }
]</code></pre>
                    <div class="alert alert-info small mt-3">
                        <i class="bi bi-image me-1"></i><strong>Image Support:</strong>
                        <ul class="mb-0 mt-1">
                            <li><code>images</code> - Array of URLs or base64 data (recommended)</li>
                            <li><code>image_url</code> - Single external URL (legacy)</li>
                            <li><code>image</code> - Single base64 image (legacy)</li>
                        </ul>
                        <small>Supported: JPEG, PNG, GIF, WebP (max 5MB each)</small>
                    </div>
                    <h6 class="mt-3">Available Statuses:</h6>
                    <ul class="small text-muted">
                        <li>in-stock</li>
                        <li>low-stock</li>
                        <li>out-of-stock</li>
                        <li>in-china</li>
                        <li>in-myanmar</li>
                    </ul>
                    <h6 class="mt-3">Available Locations:</h6>
                    <ul class="small text-muted">
                        <li>warehouse</li>
                        <li>store</li>
                        <li>china</li>
                        <li>myanmar</li>
                    </ul>
                    <h6 class="mt-3">Available Categories:</h6>
                    <ul class="small text-muted">
                        <li>action-figures</li>
                        <li>dolls</li>
                        <li>vehicles</li>
                        <li>building</li>
                        <li>educational</li>
                        <li>outdoor</li>
                        <li>games</li>
                        <li>arts</li>
                        <li>electronics</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
