@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Consume Item for Product: {{ $product->name }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('products.items.consume.store', $product) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="item_id" class="form-label">Item</label>
                            <select id="item_id" class="form-select @error('item_id') is-invalid @enderror" name="item_id" required>
                                <option value="">Select an item</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} (Stock: {{ $item->total_stock }})
                                    </option>
                                @endforeach
                            </select>
                            @error('item_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                   name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                            @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Consume Item</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
