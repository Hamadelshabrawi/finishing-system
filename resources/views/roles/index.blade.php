@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    <div class="card border-0 shadow">
        <div class="card-header bg-dark text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0 fw-bold">
                    <i class="fas fa-user-tag me-2"></i> Manage Roles
                </h3>
                @can('Create Roles')
                    <a href="{{ route('roles.create') }}" class="btn btn-success rounded-pill shadow-sm">
                        <i class="fas fa-plus-circle me-2"></i> Create New Role
                    </a>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <!-- Search Box -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group shadow-sm rounded-pill">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0 rounded-end-pill" placeholder="Search roles or permissions...">
                    </div>
                </div>
            </div>

            <!-- Roles Table -->
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover align-middle" id="rolesTable">
                    <thead class="table-dark" style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th class="py-3 ps-4" style="width: 25%; min-width: 200px;">Role Name</th>
                            <th class="py-3" style="width: 50%;">Permissions</th>
                            <th class="py-3 pe-4 text-center" style="width: 25%; min-width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr class="role-row">
                                <td class="fw-bold ps-4 align-middle">
                                    <span class="d-inline-block me-2">
                                        <i class="fas fa-shield-alt text-primary"></i>
                                    </span>
                                    {{ $role->name }}
                                </td>
                                <td class="align-middle">
                                    @foreach($role->permissions as $permission)
                                        <span style="color:white !important" class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 px-3 py-2 me-2 mb-2 shadow-sm ">
                                            {{ $permission->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="pe-4 text-center align-middle">
                                    <div class="d-flex justify-content-center gap-2">
                                        @can('Edit Role')
                                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-outline-warning rounded-pill shadow-sm px-3">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                        @endcan
                                        @can('Delete Role')
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill shadow-sm px-3" 
                                                        onclick="return confirm('Are you sure you want to delete this role?')">
                                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .card {
            border-radius: 0.75rem;
            overflow: hidden;
        }
        
        .card-header {
            padding: 1.25rem 1.5rem;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: none;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
            transform: translateY(-1px);
        }
        
        .badge {
            font-weight: 500;
            font-size: 0.75rem;
        }
        
        .btn-outline-warning {
            color: #ffc107;
            border-color: #ffc107;
        }
        
        .btn-outline-warning:hover {
            background-color: #ffc107;
            color: #212529;
        }
        
        .btn-outline-danger {
            color: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }
        
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('rolesTable');
            const rows = table.querySelectorAll('.role-row');
            
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                
                rows.forEach(row => {
                    const roleName = row.cells[0].textContent.toLowerCase();
                    const permissions = row.cells[1].textContent.toLowerCase();
                    
                    if (roleName.includes(searchTerm) || permissions.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
    @endpush
@endsection