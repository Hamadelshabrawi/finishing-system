@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $supplier->name }}</h5>
                    <div>
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('suppliers.outsources', $supplier) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-external-link-alt"></i> View Outsourcing
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <strong>Location:</strong>
                            <p>{{ $supplier->location }}</p>
                        </div>
                        <div class="col-md-3">
                            <strong>Contact:</strong>
                            <p>{{ $supplier->contact }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Description:</strong>
                            <p>{{ $supplier->description ?? 'No description provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
