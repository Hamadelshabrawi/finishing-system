@extends('layouts.app')

@section('title', \App\Models\Translation::getTranslation('edit_project'))

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

    <h1>{{ \App\Models\Translation::getTranslation('edit_project') }}</h1>

    <form id="projectEditForm" action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Project Contacts -->
        <div class="card mb-4">
            <!-- Project Contact -->
            <div class="col-12">
                <h5 class="mb-3">{{ \App\Models\Translation::getTranslation('project_contacts_card') }}</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ \App\Models\Translation::getTranslation('contact_name') }} *</label>
                            <input type="text" name="contacts[0][name]" class="form-control" required value="{{ $project->contacts->first()?->name ?? '' }}">
                        </div>
                    </div>
                    <input type="hidden" name="contacts[0][id]" value="{{ $project->contacts->first()?->id ?? '' }}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ \App\Models\Translation::getTranslation('contact_position') }} *</label>
                            <input type="text" name="contacts[0][position]" class="form-control" required value="{{ $project->contacts->first()?->position ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ \App\Models\Translation::getTranslation('contact_phone') }}</label>
                            <input type="tel" name="contacts[0][phone_number]" class="form-control" value="{{ $project->contacts->first()?->phone_number ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ \App\Models\Translation::getTranslation('contact_email') }}</label>
                            <input type="email" name="contacts[0][email]" class="form-control" value="{{ $project->contacts->first()?->email ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date">{{ \App\Models\Translation::getTranslation('start_date') }}</label>
                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $project->date ? $project->date->format('Y-m-d') : '') }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ \App\Models\Translation::getTranslation('invalid_date', ['0' => 'start date']) }}</div>
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
                    <label for="contact_value">Contract Value</label>
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
                    <ul id="initialFileList" class="file-list mt-2"></ul> </div>

                {{-- Existing Initial Files Section --}}
                @if($project->initialFiles->count())
                    <h6 class="fw-bold mb-3">Existing Initial Files:</h6>
                    <div class="file-list existing-files"> {{-- Added 'existing-files' class for distinct styling if needed --}}
                        @foreach($project->initialFiles as $file)
                            <div class="file-item d-flex justify-content-between align-items-center p-2 border-bottom">
                                {{-- File Name or View Link --}}
                                <div class="d-flex align-items-center">
                                    <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-success me-2">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <span>{{ basename($file->file_path) }}</span> {{-- Display file name --}}
                                </div>

                                {{-- Delete Option --}}
                                <div class="delete-option form-check">
                                    <input type="checkbox" name="delete_initial_files[]" value="{{ $file->id }}" class="form-check-input" id="deleteInitialFile{{ $file->id }}">
                                    <label class="form-check-label" for="deleteInitialFile{{ $file->id }}">Delete</label>
                                </div>

                                {{-- Upload Date/Time --}}
                                <div class="file-timestamp">
                                    <label class="form-check-label">{{ $file->created_at->format('Y-m-d H:i') }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropArea = document.getElementById('initialDropArea');
                const fileInput = dropArea.querySelector('.file-input');
                const fileList = document.getElementById('initialFileList'); // This is for NEWLY selected files
                const fileMessage = dropArea.querySelector('.file-message');

                // Function to handle file selection and update the NEW file list
                function handleFiles(files) {
                    fileList.innerHTML = ''; // Clear previous list of NEW files
                    if (files.length > 0) {
                        fileMessage.textContent = `${files.length} file(s) selected`; // Update message to show count
                        for (const file of files) {
                            const listItem = document.createElement('li');
                            listItem.textContent = file.name;
                            // You might want to add a way to remove newly added files before submission
                            // For example: <li data-file-name="${file.name}">... <button class="remove-new-file">X</button></li>
                            fileList.appendChild(listItem);
                        }
                    } else {
                        fileMessage.textContent = 'Drag & Drop files here or click to browse'; // Reset message if no files
                    }
                }

                // Handle file input change (when clicking to browse)
                fileInput.addEventListener('change', function() {
                    handleFiles(this.files);
                });

                // Handle drag-and-drop events
                dropArea.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropArea.classList.add('highlight');
                });

                dropArea.addEventListener('dragleave', () => {
                    dropArea.classList.remove('highlight');
                });

                dropArea.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dropArea.classList.remove('highlight');
                    const files = e.dataTransfer.files;
                    fileInput.files = files; // Assign dropped files to the input
                    handleFiles(files);
                });

                // Optional: Add styling for drag-and-drop highlight
                // This is important to include if you haven't already globally defined these styles
                const style = document.createElement('style');
                style.textContent = `
                    .file-drop-area {
                        border: 2px dashed #ccc;
                        border-radius: 5px;
                        padding: 30px;
                        text-align: center;
                        cursor: pointer;
                        transition: border .2s ease-in-out;
                    }
                    .file-drop-area.highlight {
                        border-color: #007bff;
                        background-color: #e9f5ff;
                    }
                    /* Styling for newly selected files list */
                    .file-list {
                        list-style: none;
                        padding: 0;
                    }
                    .file-list li {
                        background-color: #f8f9fa;
                        border: 1px solid #e2e6ea;
                        padding: 8px 12px;
                        margin-bottom: 5px;
                        border-radius: 4px;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }
                    /* Styling for existing files (can be customized further) */
                    .file-item {
                        background-color: #ffffff; /* Lighter background for existing files */
                        border: 1px solid #dee2e6; /* A bit more defined border */
                        margin-bottom: 8px;
                        border-radius: 5px;
                    }
                    .file-item a {
                        white-space: nowrap; /* Prevent button text from wrapping */
                    }
                    .file-item span {
                        word-break: break-all; /* Break long file names */
                        flex-grow: 1; /* Allow file name to take available space */
                        margin-right: 10px; /* Spacing before delete option */
                    }
                    .delete-option {
                        margin-left: auto; /* Push delete to the right */
                    }
                    .file-timestamp {
                        font-size: 0.85em;
                        color: #6c757d;
                        margin-left: 15px; /* Spacing from delete */
                    }
                `;
                document.head.appendChild(style);
            });
        </script>

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