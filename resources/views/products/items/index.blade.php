@extends('layouts.app')

@section('title') Product Items @endsection

@section('content')
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Product Items for "{{ $product->name }}"</h1>
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Product Details
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Product Items Card --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Product Items</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
                    <i class="fas fa-plus me-2"></i> Add Item
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->items as $item)
                                <tr>
                                    
                                    <td>{{ $item->item->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->unit_price }}</td>
                                    <td>{{ $item->total_price }}</td>
                                    <td>
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editItemModal"
                                                data-product-id="{{ $product->id }}"
                                                data-item-id="{{ $item->item_id }}"
                                                data-item-name="{{ $item->item->name }}"
                                                data-quantity="{{ $item->quantity }}"
                                                data-unit-price="{{ $item->unit_price }}"
                                                data-total-price="{{ $item->total_price }}"
                                                title="Edit Item">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                                        data-bs-target="#deleteItemModal"
                                                        data-item-id="{{ $item->item_id }}"
                                                        data-item-name="{{ $item->item->name }}"
                                                        title="Delete Item">
                                                        <i class="fas fa-trash"></i>
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

    <!-- Add Item Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemModalLabel">Add Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('product.items.store', $product->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="item_id" class="form-label">Item</label>
                            <select class="form-select @error('item_id') is-invalid @enderror" id="item_id" name="item_id" required>
                                <option value="">Select an item</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('item_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" min="1" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Item Modal -->
    <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editItemForm" action="{{ route('product.items.update', ['product' => $product->id, 'item' => 0]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="item_id" id="edit_item_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_item_name" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="edit_item_name" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="edit_quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="edit_quantity" name="quantity" min="1" required>
                        </div>
                        <div class="mb-3" style="display: none;">
                            <label for="edit_unit_price" class="form-label">Unit Price</label>
                            <input type="hidden" class="form-control" id="edit_unit_price" name="unit_price" step="0.01" min="0" required>
                        </div>
                        <div class="mb-3" style="display: none;">
                            <label for="edit_total_price" class="form-label">Total Price</label>
                            <input type="hidden" class="form-control" id="edit_total_price" name="total_price" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Item Confirmation Modal -->
    <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteItemModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteItemBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Item Modal -->
    <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteItemModalLabel">Delete Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this item?</p>
                    <p class="text-muted" id="deleteItemName"></p>
                    <form id="deleteItemForm" action="{{ route('product.items.destroy', ['product' => $product->id, 'item_id' => $item->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="item_id" id="delete_item_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteItemBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap Bundle with Popper (Assumed to be here or in layouts.app after this section) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc0sjsG9l1TAk7E7+7G1+40Tf1M3sS4j+40LuyvM+pB8F4U1f4d8z7z8c6C/t2H8z9L7/eB5Q==" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the delete item modal once
            const deleteItemModalElement = document.getElementById('deleteItemModal');
            const deleteItemModal = new bootstrap.Modal(deleteItemModalElement);
            let formToSubmitItem = null;

            // Event listener for all delete item buttons
            document.querySelectorAll('[data-bs-target="#deleteItemModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.dataset.itemId;
                    const itemName = this.dataset.itemName;
                    
                    // Update modal content
                    document.getElementById('deleteItemName').textContent = itemName;
                    document.getElementById('delete_item_id').value = itemId;
                    
                    // Update form action URL
                    const form = document.getElementById('deleteItemForm');
                    const route = `{{ route('product.items.destroy', ['product' => $product->id, 'item_id' => 'ITEM_ID']) }}`;
                    form.action = route.replace('ITEM_ID', itemId);
                    
                    deleteItemModal.show();
                });
            });

            // Event listener for the "Delete" button inside the delete item modal
            document.getElementById('confirmDeleteItemBtn').addEventListener('click', function() {
                const form = document.getElementById('deleteItemForm');
                form.submit();
                deleteItemModal.hide();
            });

            // Edit item modal events
            document.querySelectorAll('[data-bs-target="#editItemModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.dataset.itemId;
                    const itemName = this.dataset.itemName;
                    const quantity = this.dataset.quantity;
                    const unitPrice = this.dataset.unitPrice;
                    const totalPrice = this.dataset.totalPrice;

                    // Set form data
                    document.getElementById('edit_item_id').value = itemId;
                    document.getElementById('edit_item_name').value = itemName;
                    document.getElementById('edit_quantity').value = quantity;
                    document.getElementById('edit_unit_price').value = unitPrice;
                    document.getElementById('edit_total_price').value = totalPrice;

                    // Update form action URL
                    const form = document.getElementById('editItemForm');
                    const route = `{{ route('product.items.update', ['product' => $product->id, 'item' => 'ITEM_ID']) }}`;
                    form.action = route.replace('ITEM_ID', itemId);
                });
            });
        });
    </script>
@endsection
<!-- Include Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

