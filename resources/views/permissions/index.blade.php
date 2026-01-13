@extends('layouts.app')

@section('title', __('permissions.title'))

@section('content')
    <div class="card">
        <div class="card-header bg-dark text-center">
            <h3 class="mb-0 fw-bold text-white">{{ __('permissions.manage.title') }}</h3>
        </div>

        <div class="card-body">
            @can('Create Permission')
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="col-md-4">
                        <div class="input-group rounded-pill shadow-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-start-0 rounded-end-pill" placeholder="Search permissions...">
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('permissions.create') }}" class="btn btn-success shadow-sm rounded-pill">
                            <i class="fas fa-plus-circle me-2"></i> {{ __('permissions.create.new') }}
                        </a>
                    </div>
                </div>
            @else
                <div class="col-md-4 mb-3">
                    <div class="input-group rounded-pill shadow-sm">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0 rounded-end-pill" placeholder="Search permissions...">
                    </div>
                </div>
            @endcan

            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-striped align-middle shadow-sm" id="permissionsTable">
                    <thead class="table-dark text-center" style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th class="py-3">{{ __('permissions.table.name') }} </th>
                            <th class="py-3">{{ __('permissions.table.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td class="fw-bold">{{ $permission->name }}</td>
                                <td class="text-center">
                                    @can('Edit Permission')
                                        <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-warning btn-sm rounded-pill shadow-sm">
                                            <i class="fas fa-edit"></i> {{ __('permissions.edit.button') }}
                                        </a>
                                    @endcan
                                    @can('Delete Permission')
                                        <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded-pill shadow-sm">
                                                <i class="fas fa-trash-alt"></i> {{ __('permissions.delete.button') }}
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('permissionsTable');
            const rows = table.getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                
                for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
                    const row = rows[i];
                    const permissionName = row.cells[0].textContent.toLowerCase();
                    
                    if (permissionName.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    </script>
    @endpush
@endsection