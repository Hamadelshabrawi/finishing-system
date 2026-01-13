@extends('layouts.app')
@section('title') Products  @endsection

@push('styles')
    {{-- DataTables Bootstrap 5 CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        {{-- Success Message Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm rounded-lg">
            <div class="card-header bg-light py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Products</h3>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Create New Product
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    {{-- Added id="products-table" for DataTables initialization --}}
                    <table id="products-table" class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Project</th>
                                <th scope="col">Description</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->project->project_name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($product->description, 50) }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- jQuery (required by DataTables) --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    {{-- DataTables JS --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    {{-- DataTables Bootstrap 5 JS --}}
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    {{-- Font Awesome for icons --}}
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    {{-- Initialize DataTables --}}
    <script>
        $(document).ready(function() {
            $('#products-table').DataTable();
        });
    </script>
@endpush
