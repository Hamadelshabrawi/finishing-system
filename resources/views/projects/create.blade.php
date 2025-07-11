@extends('layouts.app')

@section('title', \App\Models\Translation::getTranslation('create_project'))

@section('content')

    @include('projects.partials.style')

    <h1>{{ \App\Models\Translation::getTranslation('create_project') }}</h1>

    <form id="projectForm" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date">{{ \App\Models\Translation::getTranslation('start_date') }}</label>
                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}">
                    @error('date')
                        <div class="invalid-feedback">{{ \App\Models\Translation::getTranslation('invalid_date', ['0' => 'start date']) }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="project_name">{{ \App\Models\Translation::getTranslation('project_name') }}</label>
                    <input type="text" name="project_name" id="project_name" class="form-control @error('project_name') is-invalid @enderror" value="{{ old('project_name') }}" required>
                    @error('project_name')
                        <div class="invalid-feedback">{{ \App\Models\Translation::getTranslation('required_field') }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="execution_period">{{ \App\Models\Translation::getTranslation('execution_period') }}</label>
                    <input type="number" name="execution_period" id="execution_period" class="form-control @error('execution_period') is-invalid @enderror" min="1" value="{{ old('execution_period') }}">
                    @error('execution_period')
                        <div class="invalid-feedback">{{ \App\Models\Translation::getTranslation('min_value', ['0' => '1']) }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="delivery_date">{{ \App\Models\Translation::getTranslation('delivery_date') }}</label>
                    <input type="date" name="delivery_date" id="delivery_date" class="form-control @error('delivery_date') is-invalid @enderror" value="{{ old('delivery_date') }}">
                    @error('delivery_date')
                        <div class="invalid-feedback">{{ \App\Models\Translation::getTranslation('invalid_date', ['0' => 'delivery date']) }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="technical_approval">{{ \App\Models\Translation::getTranslation('technical_approval') }}</label>
                    <select name="technical_approval" class="form-control @error('technical_approval') is-invalid @enderror" >
                        <option value="pending" {{ old('technical_approval', 'pending') == 'pending' ? 'selected' : '' }}>{{ \App\Models\Translation::getTranslation('pending_approval') }}</option>
                        <option value="approved" {{ old('technical_approval') == 'approved' ? 'selected' : '' }}>{{ \App\Models\Translation::getTranslation('approved') }}</option>
                        <option value="need_modify" {{ old('technical_approval') == 'need_modify' ? 'selected' : '' }}>{{ \App\Models\Translation::getTranslation('need_modify') }}</option>
                        <option value="dismissed" {{ old('technical_approval') == 'dismissed' ? 'selected' : '' }}>{{ \App\Models\Translation::getTranslation('dismissed') }}</option>
                    </select>
                    @error('technical_approval')
                        <div class="invalid-feedback">{{ \App\Models\Translation::getTranslation('required_field') }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="delivery_location">{{ \App\Models\Translation::getTranslation('delivery_location') }}</label>
                    <input type="text" name="delivery_location" id="delivery_location" class="form-control @error('delivery_location') is-invalid @enderror" value="{{ old('delivery_location') }}">
                    @error('delivery_location')
                        <div class="invalid-feedback">{{ \App\Models\Translation::getTranslation('required_field') }}</div>
                    @enderror
                </div>
            </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="client_id">{{ \App\Models\Translation::getTranslation('client') }}</label>
                        <div class="input-group">
                            <select name="client_id" id="client_id" class="form-control @error('client_id') is-invalid @enderror">
                                <option value="">{{ \App\Models\Translation::getTranslation('select_client') }}</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }} @if($client->company_name)({{ $client->company_name }})@endif
                                    </option>
                                @endforeach
                            </select>
                            
                            <a type="button" class="btn btn-outline-secondary" href="{{ route('clients.create') }}">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                        @error('client_id')
                            <div class="invalid-feedback">{{ \App\Models\Translation::getTranslation('required_field') }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="form-group">
                    <label for="description">{{ \App\Models\Translation::getTranslation('project_description') }}</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ \App\Models\Translation::getTranslation('required_field') }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="initial_files">{{ \App\Models\Translation::getTranslation('upload_initial_files') }}</label>
                    <div id="initialDropArea" class="file-drop-area">
                        <span class="file-message">Drag & Drop files here or click to browse</span>
                        <input type="file" name="initial_files[]" class="file-input @error('initial_files') is-invalid @enderror" multiple>
                    </div>
                    @error('initial_files')
                        <div class="invalid-feedback">{{ \App\Models\Translation::getTranslation('required_field') }}</div>
                    @enderror
                    <ul id="initialFileList" class="file-list mt-2"></ul> 
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropArea = document.getElementById('initialDropArea');
                const fileInput = dropArea.querySelector('.file-input');
                const fileList = document.getElementById('initialFileList');
                const fileMessage = dropArea.querySelector('.file-message');

                // Function to handle file selection and update the file list
                function handleFiles(files) {
                    fileList.innerHTML = ''; // Clear previous list
                    if (files.length > 0) {
                        fileMessage.textContent = `${files.length} file(s) selected`; // Update message to show count
                        for (const file of files) {
                            const listItem = document.createElement('li');
                            listItem.textContent = file.name;
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
                `;
                document.head.appendChild(style);
            });
        </script>

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
                                        <input type="text" name="contacts[0][name]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Position *</label>
                                        <input type="text" name="contacts[0][position]" class="form-control">
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