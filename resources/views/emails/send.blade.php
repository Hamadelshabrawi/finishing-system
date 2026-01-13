@extends('layouts.app')

@section('title') Send Email @endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Send Email</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('email.send') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($project))
                <input type="hidden" name="project_id" value="{{ $project->id }}">
            @endif
            
            <div class="form-group">
                <label>To</label> @dd(project)
                <input type="email" name="to" class="form-control @error('to') is-invalid @enderror" 
                       value="{{ old('to', $project) }}" required>
                @error('to')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" 
                       value="{{ old('subject', $defaultData['subject'] ?? '') }}" required>
                @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Message</label>
                <textarea name="message" class="form-control @error('message') is-invalid @enderror" 
                          rows="10" required>{{ old('message', $defaultData['message'] ?? '') }}</textarea>
                @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Attachments</label>
                <input type="file" name="attachments[]" multiple class="form-control-file">
                
                @if(isset($project) && $project->files->count())
                    <div class="mt-3">
                        <h6>Project Files:</h6>
                        <ul>
                            @foreach($project->files as $file)
                                <li>{{ $file->name }} (will be automatically attached)</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <small class="form-text text-muted">
                    Max file size: 10MB (additional project files will be included automatically)
                </small>
            </div>

            <button type="submit" class="btn btn-primary">Send Email</button>
        </form>
    </div>
</div>
@endsection