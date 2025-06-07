@extends('layouts.app')

@section('title') Dashboard @endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>{{ __('projects.my_projects') }}</h2>
                <a href="{{ route('projects.create') }}" class="btn btn-primary">
                    <i class="fe fe-plus"></i> {{ __('projects.create_project') }}
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('projects.date') }}</th>
                                    <th>{{ __('projects.item_name') }}</th>
                                    <th>{{ __('projects.client') }}</th>
                                    <th>{{ __('projects.status') }}</th>
                                    <th>{{ __('projects.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                <tr>
                                    <td>{{ $project->date->format('Y-m-d') }}</td>
                                    <td>{{ $project->item_name }}</td>
                                    <td>{{ $project->client->name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $project->status_badge }}">
                                            {{ __('projects.' . $project->initial_approval) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-info">
                                            <i class="fe fe-eye"></i>
                                        </a>
                                        <!-- Add other action buttons -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection