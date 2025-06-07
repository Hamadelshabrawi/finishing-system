<!-- Outsource Section -->
<div class="info-section mt-5">
    <h5 class="section-title">Add Outsources</h5>

    @if(session('outsource_success'))
        <div class="alert alert-success">
            {{ session('outsource_success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('outsources.store', $project->id) }}">
        @csrf
        <div id="outsource-rows">
            <!-- Initial row -->
            <div class="row mb-3 outsource-row">
                <div class="col-md-3">
                    <label>Outsource Name</label>
                    <input type="text" name="outsources[0][outsource_name]" class="form-control" placeholder="Outsource name" required>
                </div>
                <div class="col-md-2">
                    <label>Cost</label>
                    <input type="number" step="0.01" name="outsources[0][cost]" class="form-control" placeholder="Cost" required>
                </div>
                <div class="col-md-2">
                    <label>Quantity</label>
                    <input type="number" name="outsources[0][quantity]" class="form-control" placeholder="Quantity" required>
                </div>
                <div class="col-md-5">
                    <label>Boarder Note</label>
                    <input type="text" name="outsources[0][boarder_note]" class="form-control" placeholder="Optional note">
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-2">
            <button type="button" id="add-outsource-row" class="btn btn-secondary">
                <i class="fas fa-plus"></i> Add Outsource
            </button>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Save Outsources
            </button>
        </div>
    </form>

    @if($project->outsources->count() > 0)
    <div class="mt-4">
        <h6>Current Outsource List:</h6>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Cost</th>
                        <th>Quantity</th>
                        <th>Note</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($project->outsources as $outsource)
                    <tr id="outsource-{{ $outsource->id }}">
                        <td>{{ $outsource->outsource_name }}</td>
                        <td>{{ $outsource->cost }}</td>
                        <td>{{ $outsource->quantity }}</td>
                        <td>{{ $outsource->boarder_note ?? '-' }}</td>
                        <td>
                        <button class="btn btn-sm btn-outline-primary edit-outsource"
                            data-id="{{ $outsource->id }}"
                            data-name="{{ $outsource->outsource_name }}"
                            data-cost="{{ $outsource->cost }}"
                            data-quantity="{{ $outsource->quantity }}"
                            data-note="{{ $outsource->boarder_note }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>


                            <form action="{{ route('outsources.destroy', $outsource->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Are you sure you want to delete this outsource?')">
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
        <div class="alert alert-info mt-3">No outsources have been added yet.</div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let outsourceIndex = 1; // Start from 1 because the first row is 0

        // Add new row
        document.getElementById('add-outsource-row').addEventListener('click', function () {
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-3', 'outsource-row');

            newRow.innerHTML = `
                <div class="col-md-3">
                    <input type="text" name="outsources[${outsourceIndex}][outsource_name]" class="form-control" placeholder="Outsource name" required>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="outsources[${outsourceIndex}][cost]" class="form-control" placeholder="Cost" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="outsources[${outsourceIndex}][quantity]" class="form-control" placeholder="Quantity" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="outsources[${outsourceIndex}][boarder_note]" class="form-control" placeholder="Optional note">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-row">
                        <i class="fas fa-trash">Delete</i>
                    </button>
                </div>
            `;

            document.getElementById('outsource-rows').appendChild(newRow);
            outsourceIndex++;
        });

        // Remove row (using event delegation for dynamically added elements)
        document.getElementById('outsource-rows').addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                const row = e.target.closest('.outsource-row');
                // Don't allow removing the first row
                if (!row.querySelector('.remove-row').disabled) {
                    row.remove();
                    // Re-index remaining rows if needed
                    reindexRows();
                }
            }
        });

        // Edit button handlers (your existing code)
        document.querySelectorAll('.edit-outsource').forEach(function (button) {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const cost = this.dataset.cost;
                const quantity = this.dataset.quantity;
                const note = this.dataset.note || '';

                const editModal = new bootstrap.Modal(document.getElementById('editOutsourceModal'));
                
                document.getElementById('outsource_id').value = id;
                document.getElementById('outsource_name').value = name;
                document.getElementById('cost').value = cost;
                document.getElementById('quantity_outsource').value = quantity;
                document.getElementById('boarder_note').value = note;
                
                document.getElementById('editOutsourceForm').action = `/outsources/${id}`;
                
                editModal.show(); 
            });
        });

        // Function to reindex rows if needed
        function reindexRows() {
            const rows = document.querySelectorAll('.outsource-row');
            rows.forEach((row, index) => {
                if (index > 0) { // Skip the first row
                    const inputs = row.querySelectorAll('input');
                    inputs.forEach(input => {
                        const name = input.name.replace(/\[\d+\]/, `[${index}]`);
                        input.name = name;
                    });
                }
            });
            outsourceIndex = rows.length;
        }
    });
</script>