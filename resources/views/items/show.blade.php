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
    <table class="table">
        <thead>
            <tr>
                <th>Price</th>
                <th>Quantity</th>
                <th>Purchase Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($item->purchases as $purchase)
            <tr>
                <td>${{ $purchase->purchase_price }}</td>
                <td>{{ $purchase->quantity }}</td>
                <td>{{ $purchase->purchase_date }}</td>
                <td>
                    <a href="{{ route('item_purchases.edit', [$item, $purchase]) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('item_purchases.destroy', [$item, $purchase]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this purchase?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="mt-4">Consumption History</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Project</th>
                <th>Consumed Quantity</th>
                <th>Unit Cost</th>
                <th>Total Cost</th>
                <th>Consumption Date</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($item->consumptionLogs as $log)
            <tr>
                <td>{{ $log->product?->name ?? 'N/A' }}</td>
                <td>{{ $log->quantity }}</td>
                <td>${{ number_format($log->unit_cost, 2) }}</td>
                <td>${{ number_format($log->unit_price * $log->quantity, 2) }}</td>
                <td>{{ $log->created_at }}</td>
                <td>{{ $log->notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('items.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
