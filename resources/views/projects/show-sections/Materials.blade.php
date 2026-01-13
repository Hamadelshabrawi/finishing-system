<div class="info-section mt-4">
    <h5 class="section-title">Required Materials</h5>

    @if(session('material_success'))
        <div class="alert alert-success">
            {{ session('material_success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('materials.store', $project->id) }}">
        @csrf
        <div id="material-rows">
            <!-- Initial row -->
            <div class="row mb-3 material-row">
                <div class="col-md-5">
                    <label>Item</label>
                    <select name="materials[0][item_id]" class="form-control item-select" required>
                        <option value="">Select Item</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" 
                                data-unit="{{ $item->unit }}"
                                data-stock="{{ $item->total_stock }}">
                                {{ $item->name }} ({{ $item->unit }}) - Stock: {{ $item->total_stock }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Quantity</label>
                    <input type="number" step="1" name="materials[0][quantity]" class="form-control quantity" placeholder="Quantity" required>
                </div>
                <div class="col-md-2">
                    <label>Available Stock</label>
                    <input type="text" class="form-control available-stock" readonly>
                </div>
                <div class="col-md-3">
                    <label>Notes</label>
                    <input type="text" name="materials[0][notes]" class="form-control" placeholder="Optional notes">
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-between mt-2">
            <button type="button" id="add-row" class="btn btn-secondary">
                <i class="fas fa-plus"></i> Add Material
            </button>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Save Materials
            </button>
        </div>
    </form>

    @if($project->materials->count() > 0)
    <div class="mt-4">
        <h6>Current Materials List:</h6>
        <div class="table-responsive">
            <table class="table table-bordered material-table">
                <thead class="thead-dark">
                    <tr>
                        <th>Item</th>
                        <th>Unit</th>
                        <th>Quantity Needed</th>
                        <th>Available Stock</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($project->materials as $material)
                    <tr id="material-{{ $material->id }}">
                        <td>{{ $material->item->name ?? '' }}</td>
                        <td>{{ $material->item->unit ?? '' }}</td>
                        <td>{{ $material->quantity }}</td>
                        <td>{{ $material->item->total_stock ?? '' }}</td>
                        @if(isset($material->item))
                        <td>
                            @if($material->item->total_stock >= $material->quantity)
                                <span class="badge bg-success">Available</span>
                            @elseif($material->item->total_stock == 0)
                                <span class="badge bg-danger">Needs Purchase</span>
                            @else
                                <span class="badge bg-warning">Partial ({{ $material->item->total_stock }} available)</span>
                            @endif
                        </td>
                        @endif
                        <td>{{ $material->notes ?? '-' }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary edit-material" 
                                data-id="{{ $material->id }}" 
                                data-item-id="{{ $material->item_id }}"
                                data-quantity="{{ $material->quantity }}" 
                                data-notes="{{ $material->notes }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <form action="{{ route('materials.destroy', $material->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                    onclick="return confirm('Are you sure you want to delete this material?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
        <div class="alert alert-info mt-3">No materials have been added yet.</div>
    @endif
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Example jQuery
        $('.edit-material').on('click', function () {
            const materialId = $(this).data('id');
            const itemId = $(this).data('item-id');
            const quantity = $(this).data('quantity');
            const notes = $(this).data('notes');

            // Set form values
            $('#material_id').val(materialId);
            $('#item_id').val(itemId);
            $('#quantity').val(quantity);
            $('#notes').val(notes);

            // Set form action URL
            $('#editMaterialForm').attr('action', '/materials/' + materialId);

            // Open modal
            $('#editMaterialModal').modal('show');
        });

        let rowCount = 1;
        
        // Add new material row
        document.getElementById('add-row').addEventListener('click', function() {
            const row = document.createElement('div');
            row.classList.add('row', 'mb-3', 'material-row');
            
            row.innerHTML = `
                <div class="col-md-5">
                    <select name="materials[${rowCount}][item_id]" class="form-control item-select" required>
                        <option value="">Select Item</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" 
                                data-unit="{{ $item->unit }}"
                                data-stock="{{ $item->total_stock }}">
                                {{ $item->name }} ({{ $item->unit }}) - Stock: {{ $item->total_stock }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="materials[${rowCount}][quantity]" class="form-control quantity" placeholder="Quantity" required>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control available-stock" readonly>
                </div>
                <div class="col-md-2">
                    <input type="text" name="materials[${rowCount}][notes]" class="form-control" placeholder="Optional notes">
                </div>
                <div class="col-md-1 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-row">
                        Delete
                    </button>
                </div>
            `;

            
            document.getElementById('material-rows').appendChild(row);
            rowCount++;
            
            // Add event listener for the new select
            row.querySelector('.item-select').addEventListener('change', updateStockInfo);
            row.querySelector('.remove-row').addEventListener('click', function() {
                row.remove();
            });

        });
        
        // Update stock info when item is selected
        function updateStockInfo(event) {
            const row = event.target.closest('.material-row');
            const selectedOption = event.target.selectedOptions[0];
            const availableStock = row.querySelector('.available-stock');
            
            if (selectedOption.value) {
                const stock = selectedOption.dataset.stock;
                const unit = selectedOption.dataset.unit;
                availableStock.value = `${stock} ${unit}`;
            } else {
                availableStock.value = '';
            }
        }
        
        // Add event listeners to existing selects
        document.querySelectorAll('.item-select').forEach(select => {
            select.addEventListener('change', updateStockInfo);
        });
        
        // Edit material modal
        document.querySelectorAll('.edit-material').forEach(button => {
            button.addEventListener('click', function() {
                const materialId = this.getAttribute('data-id');
                
                // Fill modal with material data
                document.getElementById('material_id').value = materialId;
                document.getElementById('item_id').value = this.getAttribute('data-item-id');
                document.getElementById('quantity').value = this.getAttribute('data-quantity');
                document.getElementById('notes').value = this.getAttribute('data-notes');
                
                // Set form action
                document.getElementById('editMaterialForm').action = `/materials/${materialId}`;
                
                // Show modal
                new bootstrap.Modal(document.getElementById('editMaterialModal')).show();
            });
        });
    });
</script>