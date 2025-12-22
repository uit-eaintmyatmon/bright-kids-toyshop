@php
    $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark', 'pink', 'purple', 'indigo', 'orange', 'teal'];
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                   value="{{ old('name', $location->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" 
                   value="{{ old('slug', $location->slug ?? '') }}" placeholder="Auto-generated if empty">
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Leave empty to auto-generate from name</small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" 
                   value="{{ old('country', $location->country ?? '') }}" placeholder="e.g., China, Myanmar, Local">
            @error('country')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="color" class="form-label">Color</label>
            <select class="form-select @error('color') is-invalid @enderror" id="color" name="color">
                @foreach($colors as $color)
                    <option value="{{ $color }}" {{ old('color', $location->color ?? 'primary') == $color ? 'selected' : '' }}>
                        {{ ucfirst($color) }}
                    </option>
                @endforeach
            </select>
            @error('color')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $location->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="sort_order" class="form-label">Sort Order</label>
            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" 
                   value="{{ old('sort_order', $location->sort_order ?? 0) }}" min="0">
            @error('sort_order')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label d-block">Status</label>
            <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                       {{ old('is_active', $location->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
            </div>
        </div>
    </div>
</div>

<div class="mb-4">
    <label class="form-label">Preview</label>
    <div>
        <span class="badge bg-primary" id="colorPreview">
            <i class="bi bi-geo-alt me-1"></i>{{ $location->name ?? 'Location Name' }}
        </span>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const colorSelect = document.getElementById('color');
    const preview = document.getElementById('colorPreview');
    
    function updatePreview() {
        preview.innerHTML = '<i class="bi bi-geo-alt me-1"></i>' + (nameInput.value || 'Location Name');
        preview.className = 'badge bg-' + colorSelect.value;
    }
    
    nameInput.addEventListener('input', updatePreview);
    colorSelect.addEventListener('change', updatePreview);
    updatePreview();
});
</script>
@endpush
