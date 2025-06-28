@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white">
            <h3 class="mb-0 text-center" style="color:white">Create a New Role</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Role Name</label>
                            <input type="text" name="name" id="name" class="form-control shadow-sm" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Permissions</label>
                        <select name="permissions[]" id="permissionSelect" class="form-control" multiple="multiple" style="width: 100%">
                            @foreach($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
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
@endsection

{{-- Add this script section --}}
@push('scripts')
<script>
    $(document).ready(function() {
        $('#permissionSelect').select2({
            placeholder: "Select permissions", 
            allowClear: true
        });
    });
</script>
@endpush