@extends('layouts.app')

@section('title') Edit Client @endsection

@section('content')
    <h1 class="mb-4">Edit Client</h1>

    <form action="{{ route('clients.update', $client->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="font-weight-bold">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $client->name) }}" required placeholder="Enter client name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="font-weight-bold">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $client->email) }}" placeholder="Enter email address">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone" class="font-weight-bold">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $client->phone) }}" placeholder="Enter phone number">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="company_name" class="font-weight-bold">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', $client->company_name) }}" placeholder="Enter company name (if applicable)">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="address" class="font-weight-bold">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter address">{{ old('address', $client->address) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tax_number" class="font-weight-bold">Tax Number</label>
                    <input type="text" class="form-control" id="tax_number" name="tax_number" value="{{ old('tax_number', $client->tax_number) }}" placeholder="Enter tax number">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="commercial_registration_number" class="font-weight-bold">Commercial Registration Number</label>
                    <input type="text" class="form-control" id="commercial_registration_number" name="commercial_registration_number" value="{{ old('commercial_registration_number', $client->commercial_registration_number) }}" placeholder="Enter commercial registration number">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="type" class="font-weight-bold">Client Type</label>
            <select class="form-control" id="type" name="type">
                <option value="individual" {{ old('type', $client->type) == 'individual' ? 'selected' : '' }}>Individual</option>
                <option value="company" {{ old('type', $client->type) == 'company' ? 'selected' : '' }}>Company</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success btn-lg mt-4">Update Client</button>
    </form>
@endsection
