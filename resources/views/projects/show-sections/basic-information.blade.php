<div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0" style="color:white">{{ $project->project_name }}</h3>
        </div>
        
        <div class="card-body">
            <div class="row">
                <!-- Basic Information -->
                <div class="col-md-6">
                    <div class="info-section mb-4">
                        <h5 class="section-title border-bottom pb-2 mb-3">Basic Information</h5>
                        <div class="row">
                            <div class="col-6">
                                <p><strong>Date:</strong><br> {{ \Carbon\Carbon::parse($project->date)->format('M d, Y') }}</p>
                                <p><strong>Project Number:</strong><br> {{ $project->contact_value }}</p>
                                <p><strong>Execution Period:</strong><br> {{ $project->execution_period }} days</p>
                            </div>
                            <div class="col-6">
                                <p><strong>Delivery Date:</strong><br> {{ \Carbon\Carbon::parse($project->delivery_date)->format('M d, Y') }}</p>
                                <p><strong>Delivery Location:</strong><br> {{ $project->delivery_location }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approvals & Client -->
                <div class="col-md-6">
                    <div class="info-section mb-4">
                        <h5 class="section-title border-bottom pb-2 mb-3">Approvals @if(auth()->check() && auth()->user()->hasRole('Admin')) & Client @endif</h5>
                        <div class="approval-badges mb-3">
                            <span class="badge bg-{{ $project->technical_approval === 'approved' ? 'success' : ($project->technical_approval === 'rejected' ? 'danger' : 'warning') }} ms-2">
                                Technical: {{ ucfirst($project->technical_approval) }}
                            </span>
                        </div>
                        @if(auth()->check() && auth()->user()->hasRole('Admin'))
                            <div class="client-info">
                                <p><strong>Client:</strong><br>
                                    {{ $project->client->name }}<br>
                                    @if($project->client->company_name)
                                        {{ $project->client->company_name }}<br>
                                    @endif
                                    @if($project->client->phone)
                                        <i class="fas fa-phone"></i> {{ $project->client->phone }}<br>
                                    @endif
                                    @if($project->client->email)
                                        <i class="fas fa-envelope"></i> {{ $project->client->email }}
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="info-section mb-4">
                <h5 class="section-title border-bottom pb-2 mb-3">Description</h5>
                <div class="description-content p-3 bg-light rounded">
                    {!! nl2br(e($project->description)) !!}
                </div>
            </div>
            
            <!-- Files Sections -->
            <div class="row">
                <!-- Initial Files -->
                <div class="col-md-6">
                    <div class="info-section">
                        <h5 class="section-title border-bottom pb-2 mb-3">
                            <i class="fas fa-file-upload text-primary"></i> Initial Files
                            <span class="badge bg-secondary float-end" style="color:white">{{ $project->initialFiles->count() }}</span>
                        </h5>
                        
                        @if($project->initialFiles->count())
                            <div class="file-list">
                                @foreach($project->initialFiles as $file)
                                    <div class="file-item d-flex justify-content-between align-items-center p-2 border-bottom">
                                        <div>
                                            <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="{{ asset('storage/'.$file->file_path) }}" download class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">No initial files uploaded.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between">
                <div>
                    <small class="text-muted">Created on: {{ $project->created_at->format('M d, Y') }}</small>
                </div>
                <div>
                    @can('Edit Project')
                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-outline-primary me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    @endcan
                    @can('Delete Project')
                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this project?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>