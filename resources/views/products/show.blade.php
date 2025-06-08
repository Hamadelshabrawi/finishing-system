@extends('layouts.app')
@section('title', 'Product Details')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $product->name }}</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Product Details</div>
                                <div class="card-body">
                                    <p><strong>Project:</strong> {{ $product->project->project_name ?? 'N/A' }}</p>
                                    <p><strong>Description:</strong> {{ $product->description }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Actions</div>
                                <div class="card-body">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                                    <a href="{{ route('projects.show', $product->project->id) }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                 <h5 class="mb-0">Items</h5>
                                 <a href="{{ route('product.items.index', $product->id) }}" class="btn btn-primary btn-sm">
                                     <i class="fas fa-edit me-2"></i>Manage Items
                                 </a>
                             </div>
                                <div class="card-body">
                                    @if($product->items->isEmpty())
                                        <p>No items associated with this product.</p>
                                    @else
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($product->items as $item)
                                                    <tr>
                                                        <td>{{ $item->item->name }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ $item->unit_price }}</td>
                                                        <td>{{ $item->total_price }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Outsources</div>
                                <div class="card-body">
                                    @if($product->outsources->isEmpty())
                                        <p>No outsources associated with this product.</p>
                                    @else
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Supplier</th>
                                                    <th>Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($product->outsources as $outsource)
                                                    <tr>
                                                        <td>{{ $outsource->name }}</td>
                                                        <td>{{ $outsource->supplier->name }}</td>
                                                        <td>{{ $outsource->cost }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
