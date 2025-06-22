@extends('layouts.app')

@section('title') Show Project @endsection

@section('content')
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="mt-4"> {{-- Removed .container as per instructions --}}
        {{-- Page Header and Action Buttons --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Project Details</h1>

            <div class="d-flex flex-column flex-sm-row space-y-2 space-sm-x-3">
                <div class="btn-group">
                    <a href="{{ route('projects.export', [$project->id, 'ar']) }}" class="btn btn-outline-dark">
                        <i class="fas fa-file-export me-2"></i> Export PDF (Arabic)
                    </a>
                    <a href="{{ route('projects.export', [$project->id, 'en']) }}" class="btn btn-outline-dark">
                        <i class="fas fa-file-export me-2"></i> Export PDF (English)
                    </a>
                </div>
                <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Projects
                </a>
            </div>
        </div>

        {{-- Alert Messages for Errors and Success --}}
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong>There were some problems with your input:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Project Overview Card (incorporates detailed project information) --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">{{ $project->project_name }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Basic Information Section --}}
                    <div class="col-md-6">
                        <div class="info-section mb-4">
                            <h5 class="section-title border-bottom pb-2 mb-3">Basic Information</h5>
                            <div class="row">
                                <div class="col-6">
                                    <p><strong>Date:</strong><br> {{ \Carbon\Carbon::parse($project->date)->format('M d, Y') }}</p>
                                    <p><strong>Contract Value:</strong><br> {{ $project->contact_value }}</p>
                                    <p><strong>Execution Period:</strong><br> {{ $project->execution_period }} days</p>
                                </div>
                               
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p><strong>Delivery Date:</strong><br> {{ \Carbon\Carbon::parse($project->delivery_date)->format('M d, Y') }}</p>
                                    <p><strong>Delivery Location:</strong><br> {{ $project->delivery_location }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Approvals & Client Information Section --}}
                    <div class="col-md-6">
                        <div class="info-section mb-4">
                            <h5 class="section-title border-bottom pb-2 mb-3">Approvals @if(auth()->check() && auth()->user()->hasRole('Admin')) & Client @endif</h5>
                            <div class="approval-badges mb-3">
                                <span class="badge bg-{{ $project->technical_approval === 'approved' ? 'success' : ($project->technical_approval === 'rejected' ? 'danger' : 'warning') }} ms-2">
                                    Technical: {{ ucfirst($project->technical_approval) }}
                                </span>
                                {{-- Project Status (from previous Project Information card, now integrated here) --}}
                                <span class="badge {{ $project->status == 'Completed' ? 'bg-success' : ($project->status == 'In Progress' ? 'bg-warning text-dark' : 'bg-info') }} ms-2">
                                    Status: {{ $project->status }}
                                </span>
                            </div>
                            @if(auth()->check() && auth()->user()->hasRole('Admin'))
                                <div class="client-info">
                                    <p><strong>Client:</strong><br>
                                        {{ $project->client->name }}<br>
                                        @if($project->client->company_name)
                                            {{ $project->client->company_name }}<br>
                                        @endif
                                        @if($project->client->phone)
                                            <i class="fas fa-phone"></i> {{ $project->client->phone }}<br>
                                        @endif
                                        @if($project->client->email)
                                            <i class="fas fa-envelope"></i> {{ $project->client->email }}
                                        @endif
                                    </p>
                                    <br>
                                    <br>
                                    <br>
                                    <p><strong>Contact :</strong><br>
                    
                                    @if(isset($project->contacts))
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Position</th>
                                                        <th>Phone Number</th>
                                                        <th>Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <tr>
                                                            <td>{{ $project->contacts->name ?? 'N/A' }}</td>
                                                            <td>{{ $project->contacts->position ?? 'N/A' }}</td>
                                                            <td>{{ $project->contacts->phone_number ?? 'N/A' }}</td>
                                                            <td>{{ $project->contacts->email ?? 'N/A' }}</td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p>No contacts added for this project.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Project Description Section --}}
                <div class="info-section mb-4">
                    <h5 class="section-title border-bottom pb-2 mb-3">Description</h5>
                    <div class="description-content p-3 bg-light rounded">
                        {!! nl2br(e($project->description)) !!}
                    </div>
                </div>

                {{-- Files Sections (Initial and Technical) --}}
                <div class="row">
                    {{-- Initial Files --}}
                    <div class="col-md-6">
                        <div class="info-section">
                            <h5 class="section-title border-bottom pb-2 mb-3">
                                <i class="fas fa-file-upload text-primary"></i> Initial Files
                                <span class="badge bg-secondary float-end">{{ $project->initialFiles->count() }}</span>
                            </h5>

                            @if($project->initialFiles->count())
                                <div class="file-list">
                                    @foreach($project->initialFiles as $file)
                                        <div class="file-item d-flex justify-content-between align-items-center p-2 border-bottom">
                                            <div>
                                                <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ asset('storage/'.$file->file_path) }}" download class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">No initial files uploaded.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Footer with Creation Date and Project Actions --}}
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between">
                    <div>
                        <small class="text-muted">Created on: {{ $project->created_at->format('M d, Y') }}</small>
                    </div>
                    <div>
                        @can('Edit Project')
                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endcan
                        @can('Delete Project')
                            <form id="delete-project-form-{{ $project->id }}" action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger delete-project-btn" data-bs-toggle="modal" data-bs-target="#deleteProjectModal" data-project-id="{{ $project->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>


        {{-- Tasks Section --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Tasks</h5>
                <a href="{{ route('tasks.create', $project->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-2"></i> Add Task
                </a>
            </div>
            <div class="card-body">
                @if($project->tasks->isEmpty())
                    <p class="text-muted">No tasks created yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Assigned To</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($project->tasks as $task)
                                    <tr>
                                        <td>{{ $task->name }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td>{{ $task->assignedTo->name }}</td>
                                        <td>
                                            <span style="color:white" class="badge {{ $task->status === 'completed' ? 'bg-success' : ($task->status === 'in_progress' ? 'bg-warning' : 'bg-secondary') }}">
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                        </td>
                                        <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : '-' }}</td>
                                        <td>
                                            <form action="{{ route('tasks.destroy', [$project->id, $task->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('tasks.edit', [$project->id, $task->id]) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Project Products Table Card --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Project Products</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">
                    <i class="fas fa-plus me-2"></i> Create Product
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Items</th>
                                <th>Outsources</th>
                                <th>Notes</th>
                                <th>Final Finishes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->items->count() }}</td>
                                    <td>{{ $product->outsources->count() }}</td>
                                    <td>{{ isset($product->ProductNote) ? '1' : '0' }}</td>
                                    <td>{{ isset($product->finalFinishes) ? $product->finalFinishes->count() : '0' }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Product actions">
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-product-id="{{ $product->id }}" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Create Product Modal --}}
        <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProductModalLabel">Create New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3"></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Bootstrap Confirmation Modal for Product Deletion --}}
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this product? This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bootstrap Confirmation Modal for Project Deletion --}}
        <div class="modal fade" id="deleteProjectModal" tabindex="-1" aria-labelledby="deleteProjectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteProjectModalLabel">Confirm Project Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this **project**? This action cannot be undone, and all associated products will also be deleted.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteProjectBtn">Delete Project</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap Bundle with Popper (Assumed to be here or in layouts.app after this section) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc0sjsG9l1TAk7E7+7G1+40Tf1M3sS4j+40LuyvM+pB8F4U1f4d8z7z8c6C/t2H8z9L7/eB5Q==" crossorigin="anonymous"></script>

    <script>
        // JavaScript for Product Deletion Modal
        let formToSubmitProduct = null;
        const deleteProductModalElement = document.getElementById('deleteModal');
        const deleteProductModal = new bootstrap.Modal(deleteProductModalElement);

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                formToSubmitProduct = this.closest('form');
            });
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (formToSubmitProduct) {
                formToSubmitProduct.submit();
            }
            deleteProductModal.hide();
        });

        // JavaScript for Project Deletion Modal
        let formToSubmitProject = null;
        const deleteProjectModalElement = document.getElementById('deleteProjectModal');
        const deleteProjectModal = new bootstrap.Modal(deleteProjectModalElement);

        document.querySelectorAll('.delete-project-btn').forEach(button => {
            button.addEventListener('click', function() {
                formToSubmitProject = this.closest('form');
            });
        });

        document.getElementById('confirmDeleteProjectBtn').addEventListener('click', function() {
            if (formToSubmitProject) {
                formToSubmitProject.submit();
            }
            deleteProjectModal.hide();
        });
    </script>
@endsection
