@extends('layouts.app')

@section('title', 'Item Details')

@section('content')
<div class="container">
    <h1>Item Details: {{ $item->name }}</h1>
    <p><strong>Unit:</strong> {{ $item->unit }}</p>
    <p><strong>Selling Price:</strong> ${{ $item->selling_price }}</p>
    <p><strong>Total Stock:</strong> {{ $item->total_stock }}</p>

    <a href="{{ route('item_purchases.create', $item) }}" class="btn btn-primary">Add Purchase</a>

    <h3 class="mt-4">Purchase History</h3>
    <table class="table table-bordered">
        <tr>
            <th>Purchase Price</th>
            <th>Quantity</th>
            <th>Remaining</th>
            <th>Purchase Date</th>
        </tr>
        @foreach($item->purchases as $purchase)
        <tr>
            <td>${{ $purchase->purchase_price }}</td>
            <td>{{ $purchase->quantity }}</td>
            <td>{{ $purchase->remaining_quantity }}</td>
            <td>{{ $purchase->purchase_date }}</td>
        </tr>
        @endforeach
    </table>

    <h3 class="mt-4">Consume Stock</h3>
    <form action="{{ route('item_purchases.consume', $item) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Quantity to Consume</label>
            <input type="number" name="consume_quantity" class="form-control" min="1" required>
            @error('consume_quantity') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <button class="btn btn-danger">Consume</button>
    </form>

    <a href="{{ route('items.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
