@extends('layouts.app')

@section('title') Show Project @endsection

@section('content')
    @include('projects.show-sections.style')


    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Project Details</h1>
       
        <a href="{{ route('projects.export',$project->id) }}" class="btn btn-outline-dark">
            <i class="fas fa-arrow-left"></i> Export to PDF
        </a>
        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Projects
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="custom-tabs">
        <input type="radio" name="tabs" id="tab1" checked>
        <label for="tab1" class="tab-label">Basic Info</label>
        <div class="tab-content">
            @include('projects.show-sections.basic-information')
        </div>

        <input type="radio" name="tabs" id="tab2">
        <label for="tab2" class="tab-label">Materials</label>
        <div class="tab-content">
            @include('projects.show-sections.Materials')
        </div>

        <input type="radio" name="tabs" id="tab3">
        <label for="tab3" class="tab-label">Outsource</label>
        <div class="tab-content">
            @include('projects.show-sections.Outsource')
        </div>

        <input type="radio" name="tabs" id="tab4">
        <label for="tab4" class="tab-label">General Note</label>
        <div class="tab-content">
            @include('projects.show-sections.General-Note')
        </div>

        <input type="radio" name="tabs" id="tab5">
        <label for="tab5" class="tab-label">Final Finish</label>
        <div class="tab-content">
            @include('projects.show-sections.Final-Finish')
        </div>
    </div>

    <!-- Edit Material Modal -->
    <div class="modal fade" id="editMaterialModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editMaterialForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Material</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="material_id" name="material_id">
                        <div class="mb-3">
                            <label>Item</label>
                            <select id="item_id" name="item_id" class="form-control" required>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->unit }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Quantity</label>
                            <input type="number" step="0.01" id="quantity" name="quantity" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Notes</label>
                            <input type="text" id="notes" name="notes" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Outsource Modal -->
    <div class="modal fade" id="editOutsourceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editOutsourceForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Outsource</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="outsource_id" name="outsource_id">
                        
                        <div class="mb-3">
                            <label>Outsource Name</label>
                            <input type="text" id="outsource_name" name="outsource_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Cost</label>
                            <input type="number" step="0.01" id="cost" name="cost" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Quantity</label>
                            <input type="number" id="quantity_outsource" name="quantity" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Boarder Note</label>
                            <input type="text" id="boarder_note" name="boarder_note" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectedTab = sessionStorage.getItem("selectedTab");
        if (selectedTab) {
            document.getElementById(selectedTab).checked = true;
        }

        document.querySelectorAll("input[name='tabs']").forEach(tab => {
            tab.addEventListener("change", function () {
                sessionStorage.setItem("selectedTab", this.id);
            });
        });
    });
</script>
@endsection