@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
    <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="fas fa-user-shield me-2"></i>
                    Edit Role: <span class="fw-light">{{ $role->name }}</span>
                </h3>
                <a href="{{ route('roles.index') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left me-1"></i> Back to Roles
                </a>
            </div>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-tag me-2 text-primary"></i>
                                    Role Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">
                                        <i class="fas fa-signature me-1 text-muted"></i>
                                        Role Name
                                    </label>
                                    <input type="text" name="name" id="name"
                                           class="form-control border-2 border-top-0 border-start-0 border-end-0 rounded-0 border-primary px-0"
                                           value="{{ $role->name }}" required>
                                    <small class="text-muted">Use lowercase letters and underscores (e.g., 'content_editor')</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-key me-2 text-primary"></i>
                                    Permissions
                                </h5>
                                <div class="input-group input-group-sm w-auto">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                    <input type="text" id="permission-search" class="form-control border-start-0" placeholder="Search permissions...">
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="permissions-container p-3" style="max-height: 300px; overflow-y: auto;">
                                    <div class="row g-3" id="permissions-list">
                                        @foreach($permissions as $permission)
                                            <div class="col-12 permission-item">
                                                <div class="form-check border-bottom pb-2">
                                                    <input type="checkbox" name="permissions[]"
                                                           value="{{ $permission->id }}"
                                                           id="perm_{{ $permission->id }}"
                                                           class="form-check-input permission-checkbox"
                                                          @if($role->hasPermissionTo($permission->name)) checked @endif

                                                    <label class="form-check-label d-flex align-items-center w-100"
                                                           for="perm_{{ $permission->id }}">
                                                        <span class="badge bg-primary me-2">
                                                            <i class="fas fa-shield-alt"></i>
                                                        </span>
                                                        <span class="text-capitalize flex-grow-1 permission-name">
                                                            {{ Str::title(str_replace('_', ' ', $permission->name)) }}
                                                        </span>
                                                        <span class="badge bg-light text-dark">
                                                            {{ $permission->id }}
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="bg-light p-3 border-top d-flex justify-content-between align-items-center">
                                    <small class="text-muted d-block mt-1">
                                        {{ count($role->permissions) }} of {{ $permissions->count() }} selected
                                    </small>
                                    <div class="form-check">
                                        <input type="checkbox" id="select-all-permissions" class="form-check-input">
                                        <label class="form-check-label" for="select-all-permissions">Select All</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm">
                        <i class="fas fa-save me-2"></i> Update Role
                    </button>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary btn-lg px-4 rounded-pill ms-2">
                        <i class="fas fa-times me-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
    }

    .permissions-container::-webkit-scrollbar {
        width: 8px;
    }

    .permissions-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .permissions-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .permission-checkbox {
        margin-right: 10px;
    }

    .permission-checkbox:checked {
        background-color: #3a7bd5;
        border-color: #3a7bd5;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #3a7bd5;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const permissionSearchInput = document.getElementById('permission-search');
    const permissionsList = document.getElementById('permissions-list');
    const permissionItems = permissionsList.querySelectorAll('.permission-item');

    // Search functionality
    permissionSearchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();

        permissionItems.forEach(item => {
            const permissionName = item.querySelector('.permission-name').textContent.toLowerCase();
            if (permissionName.includes(searchTerm)) {
                item.style.display = 'block'; // Show the item
            } else {
                item.style.display = 'none'; // Hide the item
            }
        });
    });

    // Select all permissions checkbox
    const selectAll = document.getElementById('select-all-permissions');
    const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            permissionCheckboxes.forEach(checkbox => {
                // Only change if the permission item is currently visible
                if (checkbox.closest('.permission-item').style.display !== 'none') {
                    checkbox.checked = this.checked;
                }
            });
        });
    }

    // Update select all when individual permissions change
    permissionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const visibleCheckboxes = Array.from(permissionCheckboxes).filter(cb => cb.closest('.permission-item').style.display !== 'none');
            const allChecked = visibleCheckboxes.every(cb => cb.checked);
            selectAll.checked = allChecked;
        });
    });
});
</script>
@endsection