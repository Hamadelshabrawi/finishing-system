@extends('layouts.app')

@section('title', 'Create Permission')

@section('content')
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-dark text-center">
            <h3 class="mb-0 fw-bold text-white">Create Permission</h3>
        </div>
        
        <div class="card-body">
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Permission Name</label>
                    <input type="text" name="name" id="name" class="form-control shadow-sm rounded" required>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-plus-circle me-2"></i> Create Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection