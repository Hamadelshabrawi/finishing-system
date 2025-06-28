@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
    @can('View Product Details')
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
                                    <p><strong>Product:</strong> {{ $product->name }}</p>
                                    <p><strong>Description:</strong> {{ $product->description }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Actions</div>
                                <div class="card-body">
                                    @can('Edit Product')
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                                    @endcan
                                    @can('Delete Product')
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    @endcan
                                    @can('Consume Item')
                                    <a href="{{ route('products.items.consume.create', $product) }}" class="btn btn-info">Consume Items</a>
                                    @endcan
                                    <a href="{{ route('projects.show', $product->project->id) }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @can('Items List')
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Items</h5>
                                    @can('Edit Item')
                                    <a href="{{ route('product.items.index', $product->id) }}" class="btn btn-primary ">
                                        <i class="fas fa-edit me-2"></i>Manage Items
                                    </a>
                                    @endcan
                                </div>
                                <div class="card-body">
                                    @if($product->items->isEmpty())
                                        <p class="text-muted">No items added yet.</p>
                                    @else
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Quantity</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($product->items as $item)
                                                <tr>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->pivot->quantity }}</td>
                                                    <td>
                                                        @can('Edit Item')
                                                        <a href="{{ route('product.items.edit', ['product' => $product->id, 'item' => $item->id]) }}" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @endcan
                                                        @can('Delete Item')
                                                        <form action="{{ route('product.items.destroy', ['product' => $product->id, 'item' => $item->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        @endcan
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan

                    @can('View Supplier Outsourcing')
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Outsources</h5>
                                    @can('Edit Supplier')
                                    <a href="{{ route('product.outsources.index', $product) }}" class="btn btn-primary">
                                        <i class="fas fa-external-link-alt me-2"></i>Manage Outsourcing
                                    </a>
                                    @endcan
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
                    @endcan

                    @can('View Product Details')
                    @can('View Product Files')
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Product Files</h5>
                                    @can('Create Product')
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadFilesModal">
                                        <i class="fas fa-upload me-2"></i>Upload Files
                                    </button>
                                    @endcan
                                </div>
                                <div class="card-body">
                                    @if($product->files->isEmpty())
                                        <p class="text-muted">No files uploaded yet.</p>
                                    @else
                                        <div class="row">
                                            @foreach($product->files as $file)
                                                <div class="col-md-6 mb-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-{{ $file->icon }} me-2" style="font-size: 1.5rem;"></i>
                                                                <div>
                                                                    <h6 class="mb-1">{{ App\Helpers\FileHelper::decodeFilename($file->original_name) }}</h6>
                                                                    <small class="text-muted">
                                                                        {{ $file->type }} • {{ round($file->size / 1024) }} KB
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <p class="mt-2 mb-3 text-muted">{{ $file->description ?? 'No description' }}</p>
                                                            <small class="text-muted d-block">Original Name: {{ App\Helpers\FileHelper::decodeFilename($file->original_name) }}</small>
                                                            <div class="d-flex justify-content-between">
                                                                <a href="{{ route('products.files.download', ['product' => $product->id, 'file' => $file->id]) }}" class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-download"></i> Download
                                                                </a>
                                                                @can('Delete Product')
                                                                <form action="{{ route('products.files.destroy', ['product' => $product->id, 'file' => $file->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this file?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                        <i class="fas fa-trash"></i> Delete
                                                                    </button>
                                                                </form>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan @endcan

                    @can('View Product Details')
                    @can('View Final Finish')
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Final Finishes for {{ $product->name }}</h5>
                                    <div class="btn-group">
                                        @if(!$product->finalFinish)
                                            @can('Create Product')
                                            <a href="{{ route('products.final-finish.create', $product) }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Add Final Finishes
                                            </a>
                                            @endcan
                                        @else
                                            @can('Edit Product')
                                            <a href="{{ route('products.final-finish.edit', $product) }}" class="btn btn-warning">
                                                <i class="fas fa-edit me-2"></i>Edit Final Finishes
                                            </a>
                                            @endcan
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
                    @endcan
                    @endcan

                    @can('View Product Details')
                    @can('View Product Notes')
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Product Notes</h5>
                                        <div class="btn-group">
                                            @if(!isset($product->ProductNote?->note))
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                                                <i class="fas fa-plus me-2"></i>Add Note
                                            </button>
                                            @else
                                            <button type="button" class="btn btn-sm btn-warning edit-note-btn"
                                                data-note="{{ $product->ProductNote?->note ?? '' }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editNoteModal"
                                                data-note-id="{{ $product->ProductNote->id }}"> {{-- Added data-note-id --}}
                                                <i class="fas fa-edit me-2"></i>Edit Note
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-note-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteNoteModal"
                                                data-note-id="{{ $product->ProductNote->id }}"> {{-- Added data-note-id --}}
                                                <i class="fas fa-trash me-2"></i>Delete Note
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($product->ProductNote)
                                        <p>{{ $product->ProductNote->note }}</p>
                                    @else
                                        <p class="text-muted">No notes added yet</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan
                    @endcan
                </div>
            </div>
        </div>
    </div>
    @endcan

<div class="modal fade" id="uploadFilesModal" tabindex="-1" aria-labelledby="uploadFilesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadFilesModalLabel">Upload Product Files</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('products.files.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="files" class="form-label">Select Files</label>
                        <input type="file" class="form-control" id="files" name="files[]" multiple required>
                        <div class="form-text">Maximum file size: 5MB per file</div>
                    </div>
                    <div class="mb-3">
                        <label for="phase" class="form-label">File Phase</label>
                        <select class="form-select" id="phase" name="phase" required>
                            <option value="initial">Initial Phase</option>
                            <option value="technical">Technical Phase</option>
                            <option value="final">Final Phase</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload Files</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNoteModalLabel">Add Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('product.note.store', $product->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNoteModalLabel">Edit Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editNoteForm" method="POST"> {{-- Removed action and added method="POST" --}}
                @csrf
                @method('PUT') {{-- Added PUT method for updates --}}
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_note" class="form-label">Note</label>
                        <textarea class="form-control" id="edit_note" name="note" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteNoteModal" tabindex="-1" aria-labelledby="deleteNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteNoteModalLabel">Delete Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteNoteForm" method="POST"> {{-- Removed action and added method="POST" --}}
                @csrf
                @method('DELETE') {{-- Added DELETE method for deletion --}}
                <div class="modal-body">
                    <p>Are you sure you want to delete this note?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts') {{-- Use @push('scripts') to add scripts to your layout's @stack('scripts') --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Handle edit note button click
    $(document).on('click', '.edit-note-btn', function() {
        const note = $(this).data('note');
        const noteId = $(this).data('note-id');
        $('#edit_note').val(note);
        $('#editNoteForm').attr('action', `/products/{{ $product->id }}/notes/${noteId}`); // Set action dynamically
        $('#editNoteModal').modal('show');
    });

    // Handle delete note button click
    $(document).on('click', '.delete-note-btn', function() {
        const noteId = $(this).data('note-id');
        $('#deleteNoteForm').attr('action', `/products/{{ $product->id }}/notes/${noteId}`); // Set action dynamically
        $('#deleteNoteModal').modal('show');
    });
</script>
@endpush