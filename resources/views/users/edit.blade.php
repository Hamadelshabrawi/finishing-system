@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
        <div class="card-header bg-dark text-center">
            <h3 class="mb-0 fw-bold text-white">Edit User</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control shadow-sm rounded" value="{{ $user->name }}" required>
                </div>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control shadow-sm rounded" value="{{ $user->email }}" required>
                </div>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label for="role" class="form-label fw-bold">Role</label>
                    <select name="role" id="role" class="form-control shadow-sm rounded" required>
                        <option value="Admin" {{ old('user_type', $user->user_type) === 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Technical" {{ old('user_type', $user->user_type) === 'Technical' ? 'selected' : '' }}>Technical</option>
                        <option value="Financial" {{ old('user_type', $user->user_type) === 'Financial' ? 'selected' : '' }}>Financial</option>
                        <option value="Operations Manager" {{ old('user_type', $user->user_type) === 'Operations Manager' ? 'selected' : '' }}>Operations Manager</option>
                        <option value="Storekeeper" {{ old('user_type', $user->user_type) === 'Storekeeper' ? 'selected' : '' }}>Storekeeper</option>
                        <option value="User" {{ old('user_type', $user->user_type) === 'User' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                @error('role')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">New Password (Optional)</label>
                    <input type="password" name="password" id="password" class="form-control shadow-sm rounded">
                    <small class="text-muted">Leave blank if you don’t want to change the password.</small>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control shadow-sm rounded">
                </div>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-save me-2"></i> Update User
                    </button>
                </div>
            </form>
        </div>

@endsection