@extends('layouts.app')

@section('title', __('messages.project_settings.title'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('messages.project_settings.title') }}</h5>
                @can('Manage Project Settings')
                <a href="{{ route('projects.settings.create', $project) }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ __('messages.project_settings.create') }}</a>
                @endcan
            </div>
            <div class="card-body">
                @if($settings->isEmpty())
                    <p class="text-muted">{{ __('messages.no_settings') }}</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('messages.project_settings.key') }}</th>
                                <th>{{ __('messages.project_settings.name') }}</th>
                                <th>{{ __('messages.project_settings.type') }}</th>
                                <th>{{ __('messages.project_settings.value') }}</th>
                                <th>{{ __('messages.project_settings.required') }}</th>
                                <th>{{ __('messages.project_settings.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($settings as $setting)
                            <tr>
                                <td>{{ $setting->key }}</td>
                                <td>{{ $setting->name }}</td>
                                <td>{{ __('messages.project_settings.' . $setting->type) }}</td>
                                <td>{{ $setting->value }}</td>
                                <td>{{ $setting->is_required ? '✓' : '✗' }}</td>
                                <td>
                                    @can('Manage Project Settings')
                                    <div class="btn-group">
                                        <a href="{{ route('projects.settings.edit', [$project, $setting]) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('projects.settings.destroy', [$project, $setting]) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
