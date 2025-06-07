<div class="info-section mt-5">
        <h5 class="section-title">Project Note</h5>

        @if(session('note_success'))
            <div class="alert alert-success">
                {{ session('note_success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('general-note.store') }}">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            
            <div class="mb-3">
                <label for="note_content" class="form-label">Project Note</label>
                <textarea class="form-control @error('Note') is-invalid @enderror" 
                        id="note_content" 
                        name="Note" 
                        rows="3">{{ old('Note', $project->generalNote->Note ?? '') }}</textarea>
                @error('Note')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Note
            </button>
        </form>
    </div>