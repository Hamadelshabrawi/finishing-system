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

        <!-- Project Contacts -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Project Contacts</h5>
            </div>
            <div class="card-body">
                <div id="contacts-container">
                    <!-- Always show at least one contact form -->
                    <div class="contact-row">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Name *</label>
                                    <input type="text" name="contacts[0][name]" class="form-control" required value="{{ $project->contacts->first()?->name ?? '' }}">
                                </div>
                            </div>
                            <input type="hidden" name="contacts[0][id]" value="{{ $project->contacts->first()?->id ?? '' }}">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Position *</label>
                                    <input type="text" name="contacts[0][position]" class="form-control" required value="{{ $project->contacts->first()?->position ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" name="contacts[0][phone_number]" class="form-control" value="{{ $project->contacts->first()?->phone_number ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="contacts[0][email]" class="form-control" value="{{ $project->contacts->first()?->email ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Show additional contacts if they exist -->
                    @if($project->contacts->count() > 1)
                        @foreach($project->contacts->slice(1) as $index => $contact)
                            <div class="contact-row">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Name *</label>
                                            <input type="text" name="contacts[{{ $index + 1 }}][name]" class="form-control" required value="{{ $contact->name }}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="contacts[{{ $index + 1 }}][id]" value="{{ $contact->id }}">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Position *</label>
                                            <input type="text" name="contacts[{{ $index + 1 }}][position]" class="form-control" required value="{{ $contact->position }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="tel" name="contacts[{{ $index + 1 }}][phone_number]" class="form-control" value="{{ $contact->phone_number }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="contacts[{{ $index + 1 }}][email]" class="form-control" value="{{ $contact->email }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date">Start Date</label>
                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $project->date ? $project->date->format('Y-m-d') : '') }}" required>
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
                    <label for="contact_value">Contact Value</label>
                    <input type="text" name="contact_value" class="form-control @error('contact_value') is-invalid @enderror" value="{{ old('contact_value', $project->contact_value) }}" required min="1">
                    @error('contact_value')
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
                    <input type="date" name="delivery_date" id="delivery_date" class="form-control @error('delivery_date') is-invalid @enderror" value="{{ old('delivery_date', $project->delivery_date ? $project->delivery_date->format('Y-m-d') : '') }}" required>
                    @error('delivery_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="technical_approval">Project Status</label>
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

            <div class="col-md-3">
                <div class="form-group">
                    <label for="delivery_location">Delivery Location</label>
                    <input type="text" name="delivery_location" id="delivery_location" class="form-control @error('delivery_location') is-invalid @enderror" value="{{ old('delivery_location', $project->delivery_location) }}" required>
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
                                <option value="{{ $client->id }}" {{ old('client_id', $project->client_id) == $client->id ? 'selected' : '' }}>
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

        <div class="row mt-3">
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