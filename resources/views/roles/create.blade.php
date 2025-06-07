@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white">
            <h3 class="mb-0 text-center" style="color:white">Create a New Role</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Left Column: Role Name -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Role Name</label>
                            <input type="text" name="name" id="name" class="form-control shadow-sm" required>
                        </div>
                    </div>

                    <!-- Right Column: Permissions -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Permissions</label>
                        <div class="d-flex flex-wrap">
                            @foreach($permissions as $permission)
                                <div class="form-check me-3">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                        class="form-check-input">
                                    <label class="form-check-label">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-plus-circle me-2"></i> Create Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection