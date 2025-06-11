@extends('layouts.app')
@section('title') Edit Final Finishes @endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Final Finishes for {{ $product->name }}</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('products.final-finish.update', ['product' => $product]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="internal_paint" class="form-label">Internal Paint (دهانات داخلية)</label>
                                    <textarea class="form-control" id="internal_paint" name="internal_paint" rows="4">{{ $product->finalFinish->internal_paint }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="electrostatic" class="form-label">Electrostatic (الكتروستاتيك)</label>
                                    <textarea class="form-control" id="electrostatic" name="electrostatic" rows="4">{{ $product->finalFinish->electrostatic }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pvd" class="form-label">PVD</label>
                                    <textarea class="form-control" id="pvd" name="pvd" rows="4">{{ $product->finalFinish->pvd }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="polishing" class="form-label">Polishing (فرش تلميع)</label>
                                    <textarea class="form-control" id="polishing" name="polishing" rows="4">{{ $product->finalFinish->polishing }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Final Finishes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
