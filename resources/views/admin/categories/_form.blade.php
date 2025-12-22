@php
    $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark', 'pink', 'purple', 'indigo', 'orange', 'teal'];
    $icons = [
        'bi-puzzle' => 'Puzzle (Educational)',
        'bi-book' => 'Book',
        'bi-lightbulb' => 'Lightbulb (Learning)',
        'bi-gift' => 'Gift',
        'bi-controller' => 'Controller (Games)',
        'bi-robot' => 'Robot',
        'bi-palette' => 'Palette (Arts)',
        'bi-music-note' => 'Music',
        'bi-bicycle' => 'Bicycle (Outdoor)',
        'bi-car-front' => 'Car (Vehicles)',
        'bi-heart' => 'Heart',
        'bi-star' => 'Star',
        'bi-building' => 'Building (Blocks)',
        'bi-person' => 'Person (Dolls)',
        'bi-dice-5' => 'Dice (Board Games)',
        'bi-tools' => 'Tools',
    ];
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                   value="{{ old('name', $category->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" 
                   value="{{ old('slug', $category->slug ?? '') }}" placeholder="Auto-generated if empty">
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Leave empty to auto-generate from name</small>
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label for="color" class="form-label">Color</label>
            <select class="form-select @error('color') is-invalid @enderror" id="color" name="color">
                @foreach($colors as $color)
                    <option value="{{ $color }}" {{ old('color', $category->color ?? 'primary') == $color ? 'selected' : '' }}>
                        {{ ucfirst($color) }}
                    </option>
                @endforeach
            </select>
            @error('color')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="icon" class="form-label">Icon (for Featured Display)</label>
            <select class="form-select @error('icon') is-invalid @enderror" id="icon" name="icon">
                <option value="">-- Select Icon --</option>
                @foreach($icons as $iconClass => $iconLabel)
                    <option value="{{ $iconClass }}" {{ old('icon', $category->icon ?? '') == $iconClass ? 'selected' : '' }}>
                        {{ $iconLabel }}
                    </option>
                @endforeach
            </select>
            @error('icon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="sort_order" class="form-label">Sort Order</label>
            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" 
                   value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0">
            @error('sort_order')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label d-block">Status</label>
            <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                       {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label d-block">Featured Category</label>
            <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                       {{ old('is_featured', $category->is_featured ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">
                    <i class="bi bi-star-fill text-warning me-1"></i>Show on Homepage
                </label>
            </div>
            <small class="text-muted">Featured categories appear as quick filter buttons on the homepage</small>
        </div>
    </div>
</div>

<div class="mb-4">
    <label class="form-label">Preview</label>
    <div>
        <span class="badge bg-primary" id="colorPreview">{{ $category->name ?? 'Category Name' }}</span>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const colorSelect = document.getElementById('color');
    const preview = document.getElementById('colorPreview');
    
    function updatePreview() {
        preview.textContent = nameInput.value || 'Category Name';
        preview.className = 'badge bg-' + colorSelect.value;
    }
    
    nameInput.addEventListener('input', updatePreview);
    colorSelect.addEventListener('change', updatePreview);
});
</script>
@endpush
