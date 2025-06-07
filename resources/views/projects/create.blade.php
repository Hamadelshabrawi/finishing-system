@extends('layouts.app')

@section('title') Create New Project @endsection

@section('content')

    @include('projects.partials.style')

    <h1>Create New Project</h1>

    <form id="projectForm" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" required value="{{ old('date') }}">
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="project_name">Project Name</label>
                <input type="text" name="project_name" id="project_name" class="form-control @error('project_name') is-invalid @enderror" required value="{{ old('project_name') }}">
                @error('project_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="item_name">Product Name</label>
                <input type="text" name="item_name" id="item_name" class="form-control @error('item_name') is-invalid @enderror" required value="{{ old('item_name') }}">
                @error('item_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" required min="1" value="{{ old('quantity') }}">
                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="execution_period">Execution Period (days)</label>
                <input type="number" name="execution_period" id="execution_period" class="form-control @error('execution_period') is-invalid @enderror" required min="1" value="{{ old('execution_period') }}">
                @error('execution_period')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="delivery_date">Delivery Date</label>
                <input type="date" name="delivery_date" id="delivery_date" class="form-control @error('delivery_date') is-invalid @enderror" required value="{{ old('delivery_date') }}">
                @error('delivery_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="delivery_location">Delivery Location</label>
                <input type="text" name="delivery_location" id="delivery_location" class="form-control @error('delivery_location') is-invalid @enderror" required value="{{ old('delivery_location') }}">
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
                <input type="text" name="panel_number" id="panel_number" class="form-control @error('panel_number') is-invalid @enderror" required value="{{ old('panel_number') }}">
                @error('panel_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="print">Print</label>
                <select name="print" class="form-control @error('print') is-invalid @enderror" required>
                    <option value="one_to_one" {{ old('technical_approval', 'one_to_one') == 'one_to_one' ? 'selected' : '' }}>1:1</option>
                    <option value="A3" {{ old('technical_approval') == 'A3' ? 'selected' : '' }}>A3</option>
                    <option value="A4" {{ old('technical_approval') == 'A4' ? 'selected' : '' }}>A4</option>
                </select>
                @error('print')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-md-6">
            <div class="form-group">
                <label for="technical_approval">Project Status</label>
                <select name="technical_approval" class="form-control @error('technical_approval') is-invalid @enderror" required>
                    <option value="pending" {{ old('technical_approval', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ old('technical_approval') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="need_modify" {{ old('technical_approval') == 'need_modify' ? 'selected' : '' }}>Need Modify</option>
                    <option value="dismissed" {{ old('technical_approval') == 'Dismissed' ? 'selected' : '' }}>Dismissed</option>
                </select>
                @error('technical_approval')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>



    <div class="row mt-3">
        <!-- Initial Files Upload -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="initial_files">Upload Initial Files (Client Approval Phase)</label>
                <div id="initialDropArea" class="file-drop-area">
                    <span class="file-message">Drag & Drop files here or click to browse</span>
                    <input type="file" name="initial_files[]" class="file-input @error('initial_files') is-invalid @enderror" multiple>
                </div>
                @error('initial_files')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <ul id="initialFileList" class="file-list"></ul>
            </div>
        </div>

        <!-- Technical Files Upload -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="technical_files">Upload Technical Files (Technical Phase)</label>
                <div id="technicalDropArea" class="file-drop-area">
                    <span class="file-message">Drag & Drop files here or click to browse</span>
                    <input type="file" name="technical_files[]" class="file-input @error('technical_files') is-invalid @enderror" multiple>
                </div>
                @error('technical_files')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <ul id="technicalFileList" class="file-list"></ul>
            </div>
        </div>
    </div>

    @error('client_id')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary mt-3">Create Project</button>
</form>

    @include('projects.partials.client_modal')


@endsection

@push('scripts')
    @include('projects.partials.script')
@endpush