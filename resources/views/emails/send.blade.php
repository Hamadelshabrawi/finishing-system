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

        <form method="POST" action="{{ route('email.send.submit') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label>Recipients (comma separated or multiple emails)</label>
                <input type="text" name="recipients" class="form-control @error('recipients') is-invalid @enderror" 
                       value="{{ old('recipients') }}" required>
                @error('recipients')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" 
                       value="{{ old('subject') }}" required>
                @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Content</label>
                <textarea name="content" class="form-control @error('content') is-invalid @enderror" 
                          rows="10" required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Attachments (multiple files allowed)</label>
                <input type="file" name="attachments[]" multiple class="form-control-file">

                <small class="form-text text-muted">
                    Max file size: {{ ini_get('upload_max_filesize') }}
                </small>
            </div>

            <button type="submit" class="btn btn-primary">Send Email</button>
        </form>
    </div>
</div>
@endsection