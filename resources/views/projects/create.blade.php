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
                <label for="date">Start Date</label>
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
                <label for="contact_value">Contact Value</label>
                <input type="number" name="contact_value" id="contact_value" class="form-control @error('contact_value') is-invalid @enderror" required min="1" value="{{ old('contact_value') }}">
                @error('contact_value')
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
        <div class="col-md-3">
            <div class="form-group">
                <label for="delivery_location">Delivery Location</label>
                <input type="text" name="delivery_location" id="delivery_location" class="form-control @error('delivery_location') is-invalid @enderror" required value="{{ old('delivery_location') }}">
                @error('delivery_location')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="client_id">Client *</label>
                    <div class="input-group">
                        <select name="client_id" id="client_id" class="form-control @error('client_id') is-invalid @enderror" required>
                            <option value="">Select a client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }} @if($client->company_name)({{ $client->company_name }})@endif
                                </option>
                            @endforeach
                        </select>
                        
                    </div>
                    @error('client_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
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

    <div class="row mt-3">
        <!-- Project Contacts -->
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
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Project Contacts</h5>
                </div>
                <div class="card-body">
                <div id="contacts-container">
                    <div class="contact-row">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Name *</label>
                                    <input type="text" name="contacts[0][name]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Position *</label>
                                    <input type="text" name="contacts[0][position]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" name="contacts[0][phone_number]" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="contacts[0][email]" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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