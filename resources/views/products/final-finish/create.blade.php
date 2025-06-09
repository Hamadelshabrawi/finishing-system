@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Add Final Finishes for {{ $product->name }}</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('products.final-finish.store', ['product' => $product]) }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="internal_paint" class="form-label">Internal Paint (دهانات داخلية)</label>
                                    <textarea class="form-control" id="internal_paint" name="internal_paint" rows="4"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="electrostatic" class="form-label">Electrostatic (الكتروستاتيك)</label>
                                    <textarea class="form-control" id="electrostatic" name="electrostatic" rows="4"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pvd" class="form-label">PVD</label>
                                    <textarea class="form-control" id="pvd" name="pvd" rows="4"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="polishing" class="form-label">Polishing (فرش تلميع)</label>
                                    <textarea class="form-control" id="polishing" name="polishing" rows="4"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.final-finish.show', $product) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Final Finishes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
