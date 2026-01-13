<div class="info-section mt-4">
    <h5 class="section-title">Final Finish Specifications</h5>
    
    @if(session('finish_success'))
        <div class="alert alert-success">
            {{ session('finish_success') }}
        </div>
    @endif
    
    <form method="POST" action="{{ route('final-finishes.store', $project->id) }}">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Internal Paint</label>
                <input type="text" name="internal_paint" class="form-control" 
                    value="{{ $project->finalFinish->internal_paint ?? old('internal_paint') }}" 
                    placeholder="Specify internal paint details">
            </div>
            <div class="col-md-6 mb-3">
                <label>Electrostatic Coating</label>
                <input type="text" name="electrostatic" class="form-control" 
                    value="{{ $project->finalFinish->electrostatic ?? old('electrostatic') }}" 
                    placeholder="Specify electrostatic coating details">
            </div>
            <div class="col-md-6 mb-3">
                <label>PVD Coating</label>
                <input type="text" name="pvd" class="form-control" 
                    value="{{ $project->finalFinish->pvd ?? old('pvd') }}" 
                    placeholder="Specify PVD coating details">
            </div>
            <div class="col-md-6 mb-3">
                <label>Polishing</label>
                <input type="text" name="polishing" class="form-control" 
                    value="{{ $project->finalFinish->polishing ?? old('polishing') }}" 
                    placeholder="Specify polishing details">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Final Finish
        </button>
    </form>
</div>
