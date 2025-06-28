@extends('layouts.app')

@section('title', \App\Models\Translation::getTranslation('send_email'))

@section('content')
<div class="container">
    <h1>{{ \App\Models\Translation::getTranslation('send_email') }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('email.ProjectSend') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">{{ \App\Models\Translation::getTranslation('email_to') }}</label>
            <input type="email" name="to" value="{{ $project->client->email }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ \App\Models\Translation::getTranslation('subject') }}</label>
            <input type="text" name="subject" value="{{ \App\Models\Translation::getTranslation('project_update') }}: {{ $project->project_name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ \App\Models\Translation::getTranslation('message') }}</label>
            <textarea name="message" class="form-control" rows="5" required>
                {{ \App\Models\Translation::getTranslation('email_template', ['name' => $project->client->name, 'project_name' => $project->project_name, 'user_name' => Auth::user()->name]) }}
            </textarea>
        </div>

        <!-- Initial Files Section -->
        @if($project->initialFiles->count() > 0)
        <div class="mb-3">
            <label class="fw-bold form-label">{{ \App\Models\Translation::getTranslation('initial_project_files') }}</label>
            <div class="list-group mb-2">
                @foreach($project->initialFiles as $file)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <a href="{{ Storage::url($file->file_path) }}" 
                        class="btn btn-sm btn-outline-primary me-2"
                        target="_blank"
                        download="{{ basename($file->file_path) }}">
                        <i class="fas fa-download"></i> {{ \App\Models\Translation::getTranslation('download') }}
                        </a>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                name="existing_attachments[]" 
                                value="{{ $file->file_path }}" 
                                id="initial-{{ $file->id }}" checked>
                            <label class="form-check-label" for="initial-{{ $file->id }}">
                                {{ \App\Models\Translation::getTranslation('attach_to_email') }}
                            </label>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Additional Files -->
        <div class="mb-4">
            <label class="form-label">{{ \App\Models\Translation::getTranslation('additional_attachments') }}</label>
            <input type="file" name="attachments[]" class="form-control" multiple>
            <small class="text-muted">{{ \App\Models\Translation::getTranslation('multiple_files_info') }}</small>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="fas fa-paper-plane me-2"></i> {{ \App\Models\Translation::getTranslation('send_email') }}
        </button>
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
@endpush

@push('scripts')

@endpush
