@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0 fw-bold">Profile</h3>
        </div>
        <div class="card-body">
            <div class="text-center mb-4">
                @if(auth()->user()->profile_image)
                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" 
                         class="rounded-circle shadow-sm" width="150" height="150">
                @else
                    <i class="fas fa-user-circle fa-5x text-secondary"></i>
                @endif
            </div>

            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Profile Image Upload -->
                <div class="mb-4">
                    <label for="profile_image" class="form-label fw-bold">Profile Image</label>
                    <input type="file" name="profile_image" id="profile_image" 
                           class="form-control shadow-sm rounded @error('profile_image') is-invalid @enderror">
                    @error('profile_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Max 2MB (JPG, PNG, JPEG)</small>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control shadow-sm rounded" value="{{ $user->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control shadow-sm rounded" value="{{ $user->email }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">New Password</label>
                    <input type="password" name="password" id="password" class="form-control shadow-sm rounded">
                    <small class="text-muted">Leave blank to keep current password</small>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control shadow-sm rounded">
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-save me-2"></i> Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileImageInput = document.getElementById('profile_image');
    const profileImagePreview = document.querySelector('.text-center.mb-4 img');
    
    if (profileImageInput && profileImagePreview) {
        profileImageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImagePreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection