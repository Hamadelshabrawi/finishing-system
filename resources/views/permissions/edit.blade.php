@extends('layouts.app')

@section('content')
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-dark text-center">
            <h3 class="mb-0 fw-bold text-white">Update Permission</h3>
        </div>

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Please fix the errors below.
                    <ul class="mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Permission Name</label>
                    <input type="text" name="name" id="name" class="form-control shadow-sm rounded" value="{{ $permission->name }}" required>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-save me-2"></i> Update Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection