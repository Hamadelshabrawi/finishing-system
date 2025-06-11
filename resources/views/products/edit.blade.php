@extends('layouts.app')
@section('title', 'Edit Product')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Product</div>

                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="project_id" class="form-label">Project</label>
                            <select class="form-control @error('project_id') is-invalid @enderror" id="project_id" name="project_id" required>
                                <option value="">Select a project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', $product->project_id) == $project->id ? 'selected' : '' }}>
                                        {{ $project->project_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" rows="3">{{ $product->ProductNote()->note ?? '' }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('projects.show', $product->project->id) }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle note submission
            $('form').on('submit', function(e) {
                if ($('textarea[name="note"]').val()) {
                    // Prevent form submission
                    e.preventDefault();
                    
                    // Submit note first
                    $.ajax({
                        url: '{{ route('product.note.store', $product->id) }}',
                        method: 'POST',
                        data: {
                            note: $('textarea[name="note"]').val(),
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // If successful, submit the main form
                            $('form')[0].submit();
                        },
                        error: function(xhr) {
                            alert('Error saving note: ' + xhr.responseJSON.message);
                        }
                    });
                } else {
                    // If no note, just submit the form
                    return true;
                }
            });
        });
    </script>
@endpush
