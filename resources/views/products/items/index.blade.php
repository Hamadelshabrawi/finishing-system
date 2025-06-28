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
            <div class="invalid-feedback" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
                                        <button type="button" class="btn btn-sm btn-warning" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#editItemModal"
                                        data-product-id="{{ $product->id }}"
                                        data-item-id="{{ $item->id }}"
                                        data-item-name="{{ $item->item->name }}"
                                        data-quantity="{{ $item->quantity }}"
                                        data-unit-cost="{{ $item->unit_cost }}"
                                        data-cost="{{ $item->cost }}"
                                        title="Edit Item">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteItemModal-{{ $item->id }}"
                                        data-product-id="{{ $product->id }}"
                                        data-item-id="{{ $item->id }}"
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
                <form action="{{ route('product.items.store', ['product' => $product->id]) }}" method="POST">
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

                <form id="editItemForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="product_id" id="editProductId">
                    <input type="hidden" name="item_id" id="editItemId">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editItemName" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="editItemName" readonly>
                        </div>
                        <input type="hidden" name="item_id" id="editItemId">
                        <div class="mb-3">
                            <label for="editQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="editQuantity" name="quantity" required>
                        </div>
                         <div class="mb-3">
                             <label for="editCost" class="form-label">Total Cost</label>
                             <input readonly type="number" class="form-control" id="editCost" name="cost" step="0.01" >
                         </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($product->items as $item)

    <!-- Delete Item Modal -->
    <div class="modal fade" id="deleteItemModal-{{ $item->id }}" tabindex="-1" aria-labelledby="deleteItemModalLabel-{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteItemModalLabel-{{ $item->id }}">Delete Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('product.items.destroy', ['product' => $product->id, 'item' => $item->item_id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Are you sure you want to delete <span id="deleteItemName-{{ $item->id }}">{{ $item->item->name }}</span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    @endforeach
    
    {{-- Bootstrap Bundle with Popper (Assumed to be here or in layouts.app after this section) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc0sjsG9l1TAk7E7+7G1+40Tf1M3sS4j+40LuyvM+pB8F4U1f4d8z7z8c6C/t2H8z9L7/eB5Q==" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener for all edit item buttons
            document.querySelectorAll('[data-bs-target="#editItemModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const itemName = this.dataset.itemName;
                    const productId = this.dataset.productId;
                    const itemId = this.dataset.itemId;
                    const quantity = this.dataset.quantity;
                    const unitCost = this.dataset.unitCost;
                    const cost = this.dataset.cost;

                    // Set form action URL
                    document.getElementById('editItemForm').action = `/products/${productId}/items/${itemId}`;

                    // Set form data
                    document.getElementById('editProductId').value = productId;
                    document.getElementById('editItemId').value = itemId;
                    document.getElementById('editItemName').value = itemName;
                    document.getElementById('editQuantity').value = quantity;
                    document.getElementById('editUnitCost').value = unitCost;
                    document.getElementById('editCost').value = cost;
                });
            });
        });
    </script>

    {{-- Bootstrap Bundle with Popper (Assumed to be here or in layouts.app after this section) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc0sjsG9l1TAk7E7+7G1+40Tf1M3sS4j+40LuyvM+pB8F4U1f4d8z7z8c6C/t2H8z9L7/eB5Q==" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener for the "Delete" button inside the delete item modal
            document.getElementById('confirmDeleteItemBtn').addEventListener('click', function() {
                const form = document.getElementById('deleteItemForm');
                form.submit();
                deleteItemModal.hide();
            });
        });
    </script>
@endsection
<!-- Include Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit item modal handling
    const editModal = new bootstrap.Modal(document.getElementById('editItemModal'));
    const editForm = document.getElementById('editItemForm');

    // Open edit modal
    document.querySelectorAll('.edit-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            const item = this.closest('tr').dataset;
            const productId = item.productId;
            const itemId = item.itemId;

            // Set form action URL
            editForm.action = `/products/${productId}/items/${itemId}`;

            // Set hidden field values
            document.getElementById('editProductId').value = productId;
            document.getElementById('editItemId').value = itemId;
            document.getElementById('editItemName').value = item.itemName;
            document.getElementById('editQuantity').value = item.quantity;
            document.getElementById('editUnitCost').value = item.unitCost;
            document.getElementById('editCost').value = item.cost;
            
            editModal.show();
        });
    });
});
</script>

