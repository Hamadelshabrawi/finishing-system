@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-danger">Access Denied</div>
                <div class="card-body">
                    <h3 class="text-center mb-4">
                        <i class="fe fe-lock fe-64 text-danger"></i>
                    </h3>
                    <p class="text-center">You don't have permission to access this page.</p>
                    <div class="text-center mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">
                            <i class="fe fe-arrow-left"></i> Go Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection