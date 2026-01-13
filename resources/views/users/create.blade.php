@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-dark text-center">
            <h3 class="mb-0 text-white">Create User</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control shadow-sm rounded" required>
                </div>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror   

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control shadow-sm rounded" required>
                </div>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>    
                @enderror

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control shadow-sm rounded" required>
                </div>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>    
                @enderror

                <div class="mb-3">
                    <label for="role" class="form-label fw-bold">Role</label>
                    <select name="role" id="role" class="form-control shadow-sm rounded" required style="height: calc(2.5rem + 2px);">
                        <option value="" disabled selected>Select a Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Technical">Technical</option>
                        <option value="Storekeeper">Storekeeper</option>
                        <option value="Operations Manager">Operations Manager</option>
                        <option value="Financial">Financial</option>
                        <option value="User">User</option>
                    </select>
                </div>
                @error('role')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection