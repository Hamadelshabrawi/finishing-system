@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">My Tasks</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back to Projects
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($tasks->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No tasks assigned to you yet.</p>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title mb-3">Task Status</h6>
                                        <div class="d-flex justify-content-between">
                                            <span>Not Started</span>
                                            <span>{{ $tasks->where('status', 'not_started')->count() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>In Progress</span>
                                            <span>{{ $tasks->where('status', 'in_progress')->count() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Completed</span>
                                            <span>{{ $tasks->where('status', 'completed')->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Project</th>
                                                <th>Task Name</th>
                                                <th>Status</th>
                                                <th>Due Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tasks as $task)
                                                <tr>
                                                    <td>{{ $task->project->project_name }}</td>
                                                    <td>{{ $task->name }}</td>
                                                    <td>
                                                        <span class="badge {{ $task->status === 'completed' ? 'bg-success' : ($task->status === 'in_progress' ? 'bg-warning' : 'bg-secondary') }}">
                                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : '-' }}</td>
                                                    <td>
                                                        <a href="{{ route('projects.show', $task->project_id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('tasks.edit', [$task->project_id, $task->id]) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
