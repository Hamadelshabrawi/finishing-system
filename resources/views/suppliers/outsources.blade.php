@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $supplier->name }} - Outsourcing Overview</h5>
                    <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Supplier
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Outsource Name</th>
                                    <th>Project</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Cost</th>
                                    <th>Delivery Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($supplier->outsources as $outsource)
                                    <tr>
                                        <td>{{ $outsource->outsource_name }}</td>
                                        <td>
                                            <a href="{{ route('projects.show', $outsource->project) }}">
                                                {{ $outsource->project->project_name }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('products.show', $outsource->product) }}">
                                                {{ $outsource->product->name }}
                                            </a>
                                        </td>
                                        <td>{{ $outsource->quantity }}</td>
                                        <td>{{ $outsource->cost }}</td>
                                        <td>{{ $outsource->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('product.outsources.edit', [$outsource->product_id, $outsource]) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('product.outsources.destroy', [$outsource->product_id, $outsource]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this outsource?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No outsources found for this supplier</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
