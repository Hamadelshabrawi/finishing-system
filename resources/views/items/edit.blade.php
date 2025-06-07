@extends('layouts.app')
@section('title', 'Edit Item')
@section('content')
<div class="container">
    <h1>Edit Item</h1>

    <form action="{{ route('items.update', $item) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label>Unit</label>
            <input type="text" name="unit" class="form-control" value="{{ old('unit', $item->unit) }}" required>
            @error('unit') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label>Selling Price</label>
            <input type="number" step="0.01" name="selling_price" class="form-control" value="{{ old('selling_price', $item->selling_price) }}" required>
            @error('selling_price') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
