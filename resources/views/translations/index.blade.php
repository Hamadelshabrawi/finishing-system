@extends('layouts.app')

@section('title', __('messages.translations.title'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('messages.translations.title') }}</h5>
                @can('Manage Translations')
                <a href="{{ route('translations.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ __('messages.translations.create') }}</a>
                @endcan
            </div>
            <div class="card-body">
                @if($translations->isEmpty())
                    <p class="text-muted">{{ __('messages.translations.no_translations') }}</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('messages.translations.key') }}</th>
                                <th>{{ __('messages.translations.group') }}</th>
                                <th>{{ __('messages.translations.value_en') }}</th>
                                <th>{{ __('messages.translations.value_ar') }}</th>
                                <th>{{ __('messages.translations.is_active') }}</th>
                                <th>{{ __('messages.translations.description') }}</th>
                                <th>{{ __('messages.translations.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($translations as $translation)
                            <tr>
                                <td>{{ $translation->key }}</td>
                                <td>{{ $translation->group }}</td>
                                <td>{{ $translation->value_en }}</td>
                                <td>{{ $translation->value_ar }}</td>
                                <td>
                                    <span class="badge {{ $translation->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $translation->is_active ? '✓' : '✗' }}
                                    </span>
                                </td>
                                <td>{{ $translation->description }}</td>
                                <td>
                                    @can('Manage Translations')
                                    <div class="btn-group">
                                        <a href="{{ route('translations.edit', $translation) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('translations.destroy', $translation) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('messages.translations.confirm_delete') }}')">
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
