@extends('layouts.app')

@section('title')
Send Email 
@endsection

@section('content')
<div class="container">
        <h1>Send Email</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('email.send') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Email To:</label>
                <input type="email" name="to" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Subject:</label>
                <input type="text" name="subject" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Message:</label>
                <textarea name="message" class="form-control" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label>Attachments (optional):</label>
                <input type="file" name="attachments[]" class="form-control" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Send Email</button>
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
