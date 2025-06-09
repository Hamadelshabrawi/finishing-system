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
                                    <p><strong>Product:</strong> {{  $product->name  }}</p>
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
                                    <a href="{{ route('product.items.index', $product->id) }}" class="btn btn-primary ">
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
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Outsources</h5>
                                        <a href="{{ route('product.outsources.index', $product) }}" class="btn btn-primary">
                                            <i class="fas fa-external-link-alt me-2"></i>Manage Outsourcing
                                        </a>
                                </div>
                                <div class="card-body">
                                    @if($product->outsources->isEmpty())
                                        <p>No outsources associated with this product.</p>
                                    @else
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Cost</th>
                                                    <th>Quantity</th>
                                                    <th>Border Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($product->outsources as $outsource)
                                                    <tr>
                                                        <td>{{ $outsource->outsource_name }}</td>
                                                        <td>{{ $outsource->cost }}</td>
                                                        <td>{{ $outsource->quantity }}</td>
                                                        <td>{{ $outsource->boarder_note }}</td>
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
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Final Finishes for {{ $product->name }}</h5>
                                    <div class="btn-group">
                                        @if(!$product->finalFinish)
                                            <a href="{{ route('products.final-finish.create', $product) }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Add Final Finishes
                                            </a>
                                        @else
                                            <a href="{{ route('products.final-finish.edit', $product) }}" class="btn btn-warning">
                                                <i class="fas fa-edit me-2"></i>Edit Final Finishes
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-body">
                                    @if(!$product->finalFinish)
                                        <p class="text-muted">No final finishes added yet.</p>
                                    @else
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card mb-3">
                                                    <div class="card-header">
                                                        <h6 class="mb-0">Internal Paint (دهانات داخلية)</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <p>{{ $product->finalFinish->internal_paint }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card mb-3">
                                                    <div class="card-header">
                                                        <h6 class="mb-0">Electrostatic (الكتروستاتيك)</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <p>{{ $product->finalFinish->electrostatic }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card mb-3">
                                                    <div class="card-header">
                                                        <h6 class="mb-0">PVD</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <p>{{ $product->finalFinish->pvd }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card mb-3">
                                                    <div class="card-header">
                                                        <h6 class="mb-0">Polishing (فرش تلميع)</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <p>{{ $product->finalFinish->polishing }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Product Notes</h5>
                                        <div class="btn-group">
                                            @if(!isset($product->note?->note))
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNoteModal">
                                                <i class="fas fa-plus me-2"></i>Add Note
                                            </button>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-warning edit-note-btn" 
                                                style="display: none;"
                                                data-note="{{ $product->note?->note ?? '' }}"
                                                data-toggle="modal"
                                                data-target="#editNoteModal">
                                                <i class="fas fa-edit me-2"></i>Edit Note
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-note-btn" 
                                                style="display: none;"
                                                data-toggle="modal"
                                                data-target="#deleteNoteModal">
                                                <i class="fas fa-trash me-2"></i>Delete Note
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($product->note)
                                        <p>{{ $product->note->note }}</p>
                                    @else
                                        <p class="text-muted">No notes added yet</p>
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

<!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNoteModalLabel">Add Product Note</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addNoteForm" action="{{ route('product.note.store', $product) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Note Modal -->
<div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNoteModalLabel">Edit Product Note</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editNoteForm" action="{{ route('product.note.update', $product) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_note" class="form-label">Note</label>
                        <textarea class="form-control" id="edit_note" name="note" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Note Confirmation Modal -->
<div class="modal fade" id="deleteNoteModal" tabindex="-1" aria-labelledby="deleteNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteNoteModalLabel">Delete Note</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this note?</p>
                <form id="deleteNoteForm" action="{{ route('product.note.destroy', $product) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteNoteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Handle edit note button click
    $(document).on('click', '.edit-note-btn', function() {
        const note = $(this).data('note');
        $('#edit_note').val(note);
        $('#editNoteModal').modal('show');
    });

    // Handle delete note button click
    $(document).on('click', '.delete-note-btn', function() {
        $('#deleteNoteModal').modal('show');
    });

    // Handle delete confirmation
    $('#confirmDeleteNoteBtn').on('click', function() {
        $('#deleteNoteForm').submit();
    });

    // Show edit and delete buttons only if note exists
    $(document).ready(function() {
        const noteExists = {{ $product->note?->note ? 'true' : 'false' }};
        if (noteExists) {
            $('.edit-note-btn').show();
            $('.delete-note-btn').show();
        }
    });

    // Handle delete note button click
    $(document).on('click', '.delete-note-btn', function() {
        $('#deleteNoteModal').modal('show');
    });

    // Handle delete confirmation
    $('#confirmDeleteNoteBtn').on('click', function() {
        $('#deleteNoteForm').submit();
    });

    // Show edit button only if note exists
    $(document).ready(function() {
        const noteExists = {{ $product->note?->note ? 'true' : 'false' }};
        if (noteExists) {
            $('.edit-note-btn').show();
            $('.delete-note-btn').show();
        }
    });
</script>
@endpush
