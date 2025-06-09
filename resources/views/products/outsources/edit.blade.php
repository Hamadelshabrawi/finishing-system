@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Outsource') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('product.outsources.update', [$product, $outsource]) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="outsource_name" class="col-md-4 col-form-label text-md-right">{{ __('Outsource Name') }}</label>

                            <div class="col-md-6">
                                <input id="outsource_name" type="text" class="form-control @error('outsource_name') is-invalid @enderror" name="outsource_name" value="{{ old('outsource_name', $outsource->outsource_name) }}" required autocomplete="outsource_name" autofocus>

                                @error('outsource_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cost" class="col-md-4 col-form-label text-md-right">{{ __('Cost') }}</label>

                            <div class="col-md-6">
                                <input id="cost" type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror" name="cost" value="{{ old('cost', $outsource->cost) }}" required>

                                @error('cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="quantity" class="col-md-4 col-form-label text-md-right">{{ __('Quantity') }}</label>

                            <div class="col-md-6">
                                <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $outsource->quantity) }}" required>

                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="boarder_note" class="col-md-4 col-form-label text-md-right">{{ __('Border Note') }}</label>

                            <div class="col-md-6">
                                <textarea id="boarder_note" class="form-control @error('boarder_note') is-invalid @enderror" name="boarder_note" rows="3">{{ old('boarder_note', $outsource->boarder_note) }}</textarea>

                                @error('boarder_note')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Outsource') }}
                                </button>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
