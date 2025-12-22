<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                   value="{{ old('name', $user->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                   value="{{ old('email', $user->email ?? '') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password" class="form-label">
                Password 
                @if($requirePassword ?? false)
                    <span class="text-danger">*</span>
                @else
                    <small class="text-muted">(leave blank to keep current)</small>
                @endif
            </label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" 
                   {{ ($requirePassword ?? false) ? 'required' : '' }}>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>
    </div>
</div>

@if(isset($user) && $user->id === auth()->id())
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        You are editing your own account.
    </div>
@endif
