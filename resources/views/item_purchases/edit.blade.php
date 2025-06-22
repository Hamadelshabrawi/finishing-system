@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit Purchase</div>

            <div class="card-body">
                <form method="POST" action="{{ route('item_purchases.update', [$item, $purchase]) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="purchase_price" class="form-label">Purchase Price</label>
                        <input id="purchase_price" type="number" step="0.01" class="form-control @error('purchase_price') is-invalid @enderror" name="purchase_price" value="{{ old('purchase_price', $purchase->purchase_price) }}" required>
                        @error('purchase_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $purchase->quantity) }}" required min="1">
                        @error('quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="purchase_date" class="form-label">Purchase Date</label>
                        <input id="purchase_date" type="date" class="form-control @error('purchase_date') is-invalid @enderror" name="purchase_date" value="{{ old('purchase_date', $purchase->purchase_date) }}" required>
                        @error('purchase_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <div class="d-flex justify-content-end align-items-baseline">
                            <a href="{{ route('items.show', $item) }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                Update Purchase
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
