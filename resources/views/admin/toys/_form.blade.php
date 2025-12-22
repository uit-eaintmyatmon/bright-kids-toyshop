@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    <div class="row g-3">
        <div class="col-md-6">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $toy?->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku', $toy?->sku) }}" required>
            @error('sku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                <option value="">Select category...</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $toy?->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $toy?->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $toy?->price) }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
            <input type="number" min="0" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $toy?->quantity ?? 0) }}" required>
            @error('quantity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="status_id" class="form-label">Status <span class="text-danger">*</span></label>
            <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id" required>
                <option value="">Select status...</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ old('status_id', $toy?->status_id) == $status->id ? 'selected' : '' }}>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>
            @error('status_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="location_id" class="form-label">Location</label>
            <select class="form-select @error('location_id') is-invalid @enderror" id="location_id" name="location_id">
                <option value="">Select location...</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}" {{ old('location_id', $toy?->location_id) == $location->id ? 'selected' : '' }}>
                        {{ $location->name }}
                    </option>
                @endforeach
            </select>
            @error('location_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Image Upload Section -->
        <div class="col-12">
            <label class="form-label">Product Images</label>
            
            <!-- Existing Images -->
            @if($toy && $toy->images->count() > 0)
                <div class="row g-3 mb-3">
                    @foreach($toy->images as $image)
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card h-100 {{ $image->is_primary ? 'border-primary border-2' : '' }}">
                                <img src="{{ $image->image_url }}" class="card-img-top" alt="Product image" style="height: 120px; object-fit: cover;">
                                <div class="card-body p-2">
                                    @if($image->is_primary)
                                        <span class="badge bg-primary mb-1">Primary</span>
                                    @else
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="radio" name="primary_image" value="{{ $image->id }}" id="primary_{{ $image->id }}">
                                            <label class="form-check-label small" for="primary_{{ $image->id }}">
                                                Set as primary
                                            </label>
                                        </div>
                                    @endif
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="delete_{{ $image->id }}">
                                        <label class="form-check-label text-danger small" for="delete_{{ $image->id }}">
                                            Delete
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Legacy Image Display -->
            @if($toy?->image_url && (!$toy->images || $toy->images->count() === 0))
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{ $toy->image_url }}" class="card-img-top" alt="Current image" style="height: 150px; object-fit: cover;">
                            <div class="card-body p-2 text-center">
                                <small class="text-muted">Legacy Image</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Upload New Images -->
            <div class="mb-3">
                <label for="images" class="form-label">Upload New Images</label>
                <input type="file" class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" 
                       id="images" name="images[]" accept="image/jpeg,image/png,image/gif,image/webp" multiple>
                @error('images')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @error('images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Accepted: JPEG, PNG, GIF, WebP. Max size: 5MB per image. You can select multiple images.</small>
            </div>

            <!-- Image Preview -->
            <div id="imagePreview" class="row g-2 d-none">
            </div>

            <!-- Image URL option -->
            <div class="mb-3">
                <label for="image_url" class="form-label">Or Image URL (single image)</label>
                <input type="url" class="form-control @error('image_url') is-invalid @enderror" id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="https://example.com/image.jpg">
                @error('image_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">If both upload and URL provided, uploads take priority</small>
            </div>
        </div>

        <div class="col-12">
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>{{ $toy ? 'Update Toy' : 'Create Toy' }}
                </button>
                <a href="{{ route('admin.toys.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg me-1"></i>Cancel
                </a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.getElementById('images').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (this.files && this.files.length > 0) {
        preview.classList.remove('d-none');
        
        Array.from(this.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-6 col-md-3 col-lg-2';
                col.innerHTML = `
                    <div class="card">
                        <img src="${e.target.result}" class="card-img-top" alt="Preview ${index + 1}" style="height: 100px; object-fit: cover;">
                        <div class="card-body p-1 text-center">
                            <small class="text-muted">New #${index + 1}</small>
                        </div>
                    </div>
                `;
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    } else {
        preview.classList.add('d-none');
    }
});
</script>
@endpush
