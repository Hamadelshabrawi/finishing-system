@extends('layouts.app')
@section('title', 'Add Purchase for Item')
@section('content')
<div class="container">
    <h1>Add Purchase for: {{ $item->name }}</h1>

    <form action="{{ route('item_purchases.store', $item) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Purchase Price</label>
            <input type="number" step="0.01" name="purchase_price" class="form-control" value="{{ old('purchase_price') }}" required>
            @error('purchase_price') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">

        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1" required>
            @error('quantity') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Purchase Date</label>
            <input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date', now()->toDateString()) }}" required>
            @error('purchase_date') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-success">Add Purchase</button>
        <a href="{{ route('items.show', $item) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
