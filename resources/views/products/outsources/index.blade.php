@extends('layouts.app')

@section('title') Product Outsources @endsection

@section('content')
    @php
        $suppliers = \App\Models\Supplier::all();
    @endphp

    <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Product Outsources for "{{ $product->name }}"</h1>
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Product Details
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Outsources</h5>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addOutsourceModal">
                    <i class="fas fa-plus me-2"></i> Add Outsource
                </button>

                <div class="modal fade" id="addOutsourceModal" tabindex="-1" aria-labelledby="addOutsourceModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addOutsourceModalLabel">Add Outsource</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('product.outsources.store', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $product->project->id }}" name="project_id" required>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="supplier_id" class="form-label">Supplier</label>
                                        <select class="form-control @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id" required>
                                            <option value="">Select Supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="outsource_name" class="form-label">Outsource Name</label>
                                        <input type="text" class="form-control @error('outsource_name') is-invalid @enderror" id="outsource_name" name="outsource_name" required>
                                        @error('outsource_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="cost" class="form-label">Cost / 1 Quantity</label>
                                        <input type="number" class="form-control @error('cost') is-invalid @enderror" id="cost" name="cost" step="0.01" required>
                                        @error('cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" required>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="boarder_note" class="form-label">Border Note</label>
                                        <textarea class="form-control @error('boarder_note') is-invalid @enderror" id="boarder_note" name="boarder_note" rows="3"></textarea>
                                        @error('boarder_note')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add Outsource</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Supplier</th>
                                <th>Items</th>
                                <th>Quantity</th>
                                <th>cost</th>
                                <th>Border Note</th>
                                <th>Total Cost</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->outsources as $outsource)
                                <tr>
                                    <td>{{ $outsource->supplier->name }}</td>
                                    <td>{{ $outsource->outsource_name }}</td>
                                    <td>{{ $outsource->quantity }}</td>
                                    <td>{{ $outsource->cost / $outsource->quantity }}</td>
                                    <td>{{ $outsource->boarder_note }}</td>
                                    <td>{{ $outsource->cost }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning edit-outsource-btn" data-toggle="modal"
                                            data-target="#editOutsourceModal"
                                            data-outsource-id="{{ $outsource->id }}"
                                            data-outsource-name="{{ $outsource->outsource_name }}"
                                            data-cost="{{ $outsource->cost }}"
                                            data-quantity="{{ $outsource->quantity }}"
                                            data-boarder-note="{{ $outsource->boarder_note }}"
                                            data-supplier-id="{{ $outsource->supplier_id }}"
                                            title="Edit Outsource">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        <button type="button" class="btn btn-sm btn-danger delete-outsource-btn" data-toggle="modal"
                                            data-target="#deleteOutsourceModal"
                                            data-outsource-id="{{ $outsource->id }}"
                                            data-outsource-name="{{ $outsource->outsource_name }}"
                                            title="Delete Outsource">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editOutsourceModal" tabindex="-1" aria-labelledby="editOutsourceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOutsourceModalLabel">Edit Outsource</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editOutsourceForm" action="{{ route('product.outsources.update', ['product' => $product->id, 'outsource' => '__outsource_id__']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <input type="hidden" name="outsource_id" id="edit_outsource_id">
                        <div class="mb-3">
                            <label for="edit_supplier_id" class="form-label">Supplier</label>
                            <select class="form-control" id="edit_supplier_id" name="supplier_id" required>
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_outsource_name" class="form-label">Outsource Name</label>
                            <input type="text" class="form-control" id="edit_outsource_name" name="outsource_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_cost" class="form-label">Cost</label>
                            <input type="number" class="form-control" id="edit_cost" name="cost" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="edit_quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_boarder_note" class="form-label">Border Note</label>
                            <textarea class="form-control" id="edit_boarder_note" name="boarder_note" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Outsource</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteOutsourceModal" tabindex="-1" aria-labelledby="deleteOutsourceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteOutsourceModalLabel">Delete Outsource</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the outsource: <strong id="deleteOutsourceName"></strong>?</p>
                    <form id="deleteOutsourceForm" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteOutsourceBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Handle edit outsource button click
    $('.edit-outsource-btn').on('click', function() {
        const outsourceId = $(this).data('outsource-id');
        const outsourceName = $(this).data('outsource-name');
        const cost = $(this).data('cost');
        const quantity = $(this).data('quantity');
        const boarderNote = $(this).data('boarder-note');
        const supplierId = $(this).data('supplier-id');

        $('#edit_outsource_id').val(outsourceId);
        $('#edit_outsource_name').val(outsourceName);
        $('#edit_cost').val(cost);
        $('#edit_quantity').val(quantity);
        $('#edit_boarder_note').val(boarderNote);
        $('#edit_supplier_id').val(supplierId);

        // Update form action URL
        $('#editOutsourceForm').attr('action', `{{ route('product.outsources.update', ['product' => $product->id, 'outsource' => '__outsource_id__']) }}`.replace('__outsource_id__', outsourceId));
        
        // Show the modal
        $('#editOutsourceModal').modal('show');
    });


    // Handle delete outsource button click
    $(document).on('click', '.delete-outsource-btn', function() {
        var outsourceId = $(this).data('outsource-id');
        var outsourceName = $(this).data('outsource-name');
        var productId = {{ $product->id }};

        // Update form action URL
        $('#deleteOutsourceForm').attr('action', `/products/${productId}/outsources/${outsourceId}`);

        // Update modal content
        $('#deleteOutsourceName').text(outsourceName);

        // Show the modal
        $('#deleteOutsourceModal').modal('show');
    });

    // Handle delete confirmation
    $('#confirmDeleteOutsourceBtn').on('click', function() {
        $('#deleteOutsourceForm').submit();
    });
</script>
@endpush