@extends('layouts.app')

@section('title') Edit Project @endsection


@section('content')

<style>
    .file-list {
    list-style: none;
    padding: 0;
}

.file-list li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8f9fa;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 8px;
}

.file-list a {
    font-weight: bold;
    color: #007bff;
    text-decoration: none;
    transition: color 0.3s ease;
}

.file-list a:hover {
    color: #0056b3;
}

.file-list span {
    font-size: 14px;
    color: #6c757d;
    margin-left: 15px;
}

.file-list input[type="checkbox"] {
    transform: scale(1.2);
    cursor: pointer;
}
</style>
@include('projects.partials.style')

    <h1>Edit Project</h1>

    <form id="projectEditForm" action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $project->date) }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="project_name">Project Name</label>
                    <input type="text" name="project_name" id="project_name" class="form-control @error('project_name') is-invalid @enderror" value="{{ old('project_name', $project->project_name) }}" required>
                    @error('project_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="item_name">Product Name</label>
                    <input type="text" name="item_name" id="item_name" class="form-control @error('item_name') is-invalid @enderror" value="{{ old('item_name', $project->item_name) }}" required>
                    @error('item_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $project->quantity) }}" required min="1">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="execution_period">Execution Period (days)</label>
                    <input type="number" name="execution_period" id="execution_period" class="form-control @error('execution_period') is-invalid @enderror" value="{{ old('execution_period', $project->execution_period) }}" required min="1">
                    @error('execution_period')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="delivery_date">Delivery Date</label>
                    <input type="date" name="delivery_date" id="delivery_date" class="form-control @error('delivery_date') is-invalid @enderror" value="{{ old('delivery_date', $project->delivery_date) }}" required>
                    @error('delivery_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="delivery_location">Delivery Location</label>
                    <input type="text" name="delivery_location" id="delivery_location" class="form-control @error('delivery_location') is-invalid @enderror" value="{{ old('delivery_location', $project->delivery_location) }}" required>
                    @error('delivery_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <input type="hidden" name="client_id" id="selected_client_id" value="{{ old('client_id', isset($project) ? $project->client_id : '') }}">
                <div id="selected-client-display" class="mt-2">
                    <strong>Selected Client:</strong> <span id="client-name">{{ old('client_name', isset($project) ? $project->client->name : 'None Selected') }}</span>
                </div>
                <button type="button" class="btn btn-info w-100" data-toggle="modal" data-target="#clientModal">
                    Select Client
                </button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="panel_number">Panel Name / Number</label>
                    <input type="text" name="panel_number" id="panel_number" class="form-control @error('panel_number') is-invalid @enderror" value="{{ old('panel_number', $project->panel_number) }}" required>
                    @error('panel_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="print">Print</label>
                    <select name="print" class="form-control @error('print') is-invalid @enderror" required>
                        <option value="one_to_one" {{ old('print', $project->print) == 'one_to_one' ? 'selected' : '' }}>1:1</option>
                        <option value="A3" {{ old('print', $project->print) == 'A3' ? 'selected' : '' }}>A3</option>
                        <option value="A4" {{ old('print', $project->print) == 'A4' ? 'selected' : '' }}>A4</option>
                    </select>
                    @error('print')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <!-- <div class="col-md-6">
                <div class="form-group">
                    <label for="initial_approval">Initial Approval</label>
                    <select name="initial_approval" class="form-control @error('initial_approval') is-invalid @enderror" required>
                        <option value="pending" {{ old('initial_approval', $project->initial_approval) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('initial_approval', $project->initial_approval) == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('initial_approval', $project->initial_approval) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('initial_approval')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div> -->

            <div class="col-md-6">
                <div class="form-group">
                    <label for="technical_approval">Technical Approval</label>
                    <select name="technical_approval" class="form-control @error('technical_approval') is-invalid @enderror" required>
                        <option value="pending" {{ old('technical_approval', $project->technical_approval) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('technical_approval', $project->technical_approval) == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('technical_approval', $project->technical_approval) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('technical_approval')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $project->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <!-- Initial Files Upload -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="initial_files">Upload New Initial Files</label>
                    <div id="initialDropArea" class="file-drop-area">
                        <span class="file-message">Drag & Drop files here or click to browse</span>
                        <input type="file" name="initial_files[]" class="file-input @error('initial_files') is-invalid @enderror" multiple>
                    </div>
                    @error('initial_files')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <ul id="initialFileList" class="file-list"></ul>
                </div>

                @if($project->initialFiles->count())
                    <h6 class="fw-bold mb-3">Existing Initial Files:</h6>
                    <div class="file-list">
                        @foreach($project->initialFiles as $file)
                            <div class="file-item d-flex justify-content-between align-items-center p-2 border-bottom">
                                <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-eye"></i> View
                                </a>
                               
                                <div class="delete-option">
                                    <input type="checkbox" name="delete_initial_files[]" value="{{ $file->id }}" class="form-check-input">
                                    <label class="form-check-label ms-2">Delete</label>
                                </div>
                                <div class="delete-option">
                                    <label class="form-check-label ms-2">{{ $file->created_at->format('Y-m-d H:i') }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Technical Files Upload -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="technical_files">Upload New Technical Files</label>
                    <div id="technicalDropArea" class="file-drop-area">
                        <span class="file-message">Drag & Drop files here or click to browse</span>
                        <input type="file" name="technical_files[]" class="file-input @error('technical_files') is-invalid @enderror" multiple>
                    </div>
                    @error('technical_files')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <ul id="technicalFileList" class="file-list"></ul>
                </div>

                @if($project->technicalFiles->count())
                    <h6 class="fw-bold mb-3">Existing Technical Files:</h6>
                    <div class="file-list">
                        @foreach($project->technicalFiles as $file)
                            <div class="file-item d-flex justify-content-between align-items-center p-2 border-bottom">
                                <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-eye"></i> View
                                </a>
                               
                                <div class="delete-option">
                                    <input type="checkbox" name="delete_technical_files[]" value="{{ $file->id }}" class="form-check-input">
                                    <label class="form-check-label ms-2">Delete</label>
                                </div>
                                <div class="delete-option">
                                    <label class="form-check-label ms-2">{{ $file->created_at->format('Y-m-d H:i') }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>


        @error('client_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-primary mt-3">Update Project</button>
    </form>

@include('projects.partials.client_modal')

@endsection

@push('scripts')
    @include('projects.partials.script')
@endpush