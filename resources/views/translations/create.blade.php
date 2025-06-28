@extends('layouts.app')

@section('title', __('messages.translations.create'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('messages.translations.create') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('translations.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="key">{{ __('messages.translations.key') }}</label>
                                <input type="text" class="form-control @error('key') is-invalid @enderror" id="key" name="key" value="{{ old('key') }}" required>
                                @error('key')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="group">{{ __('messages.translations.group') }}</label>
                                <input type="text" class="form-control @error('group') is-invalid @enderror" id="group" name="group" value="{{ old('group', 'messages') }}" required>
                                @error('group')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="value_en">{{ __('messages.translations.value_en') }}</label>
                                <textarea class="form-control @error('value_en') is-invalid @enderror" id="value_en" name="value_en" rows="3" required>{{ old('value_en') }}</textarea>
                                @error('value_en')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="value_ar">{{ __('messages.translations.value_ar') }}</label>
                                <textarea class="form-control @error('value_ar') is-invalid @enderror" id="value_ar" name="value_ar" rows="3" required>{{ old('value_ar') }}</textarea>
                                @error('value_ar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">{{ __('messages.translations.description') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                    <label class="form-check-label" for="is_active">
                                        {{ __('messages.translations.is_active') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>{{ __('messages.save') }}</button>
                        <a href="{{ route('translations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>{{ __('messages.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
