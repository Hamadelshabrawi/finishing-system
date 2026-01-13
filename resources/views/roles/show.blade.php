@extends('layouts.app')

@section('title', 'Role Details')

@section('content')
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white">
            <h3 class="mb-0 text-center">Role Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Role Name:</label>
                        <p class="form-control-plaintext">{{ $role->name }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Created At:</label>
                        <p class="form-control-plaintext">{{ $role->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h4>Permissions:</h4>
                <div class="list-group">
                    @forelse($role->permissions as $permission)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $permission->name }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $permission->id }}</span>
                        </div>
                    @empty
                        <div class="list-group-item">
                            <p class="text-muted">No permissions assigned to this role</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i> Edit Role
                </a>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left me-2"></i> Back to Roles
                </a>
            </div>
        </div>
    </div>
@endsection
