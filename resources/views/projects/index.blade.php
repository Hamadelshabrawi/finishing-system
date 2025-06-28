@extends('layouts.app')

@section('title', \App\Models\Translation::getTranslation('title'))

@section('content')
<div class="container-fluid mt-3">
    <div class="row mb-4 align-items-center"> {{-- Added align-items-center for vertical alignment --}}
        <div class="col-md-6">
            <h1 class="mb-0">{{ \App\Models\Translation::getTranslation('title') }}</h1> {{-- Removed bottom margin for better alignment --}}
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0"> {{-- Adjusted for responsive text alignment and margin --}}
            @can('Create Project')
            <a href="{{ route('projects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> {{ \App\Models\Translation::getTranslation('create_project') }} {{-- Added me-2 for spacing --}}
            </a>
            @endcan
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover w-100" id="projects-table"> {{-- Added w-100 for full width --}}
                    <thead class="thead-light">
                        <tr>
                            <th>{{ \App\Models\Translation::getTranslation('date') }}</th>
                            <th>{{ \App\Models\Translation::getTranslation('project_name') }}</th>
                            @role('Admin')
                            <th>{{ \App\Models\Translation::getTranslation('client') }}</th>
                            <th>{{ \App\Models\Translation::getTranslation('created_by') }}</th>
                            @endrole
                            <th>{{ \App\Models\Translation::getTranslation('products') }}</th>
                            <th>{{ \App\Models\Translation::getTranslation('technical_approval') }}</th>
                            <th>{{ \App\Models\Translation::getTranslation('status') }}</th>
                            <th>{{ \App\Models\Translation::getTranslation('delivery_date') }}</th>
                            <th class="text-center">{{ \App\Models\Translation::getTranslation('actions') }}</th> {{-- Centered Actions column header --}}
                        </tr>
                    </thead>
                    <tbody>
                        {{-- DataTables will populate this tbody --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- DataTables and Font Awesome CSS --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Custom styles for better spacing and alignment */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
    }
    .actions-column {
        white-space: nowrap; /* Prevent actions buttons from wrapping */
        width: 1%; /* Try to make this column as small as possible */
    }
    /* Adjust button icon size if needed, though Font Awesome usually handles this well */
    .btn i {
        font-size: 0.9em; /* Slightly smaller icons within buttons */
    }

    /* DataTables specific adjustments for responsiveness and button appearance */
    div.dataTables_wrapper div.dataTables_filter label {
        margin-right: 0.5rem; /* Space between search label and input */
    }
    div.dataTables_wrapper div.dataTables_filter input {
        width: auto; /* Allow search input to size naturally */
        display: inline-block; /* Ensure it's inline with the label */
    }

    /* Ensure DataTables buttons are not too big */
    .dt-buttons .btn {
        margin-right: 0.5rem;
        margin-bottom: 0.5rem; /* For smaller screens, ensures buttons stack nicely */
    }

    /* Small adjustment for card-body padding if needed to make space for table */
    .card-body {
        padding: 1.25rem;
    }
</style>
@endpush

@push('scripts')
{{-- jQuery, DataTables, and Buttons JS --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> {{-- Updated to a more recent jQuery if not already included --}}
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.0/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function () {
        let columns = [
            { data: 'date', name: 'date', className: 'text-center' },
            { data: 'project_name', name: 'project_name' },
            { data: 'product_count', name: 'products_count', className: 'text-center' },
            { data: 'technical_approval', name: 'technical_approval', className: 'text-center' },
            { data: 'status', name: 'status', className: 'text-center' },
            { data: 'delivery_date', name: 'delivery_date', className: 'text-center' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'actions-column text-center' }
        ];

        @role('Admin')
            // Insert client_name and created_by columns for Admin
            columns.splice(2, 0,
                { data: 'client_name', name: 'client.name' },
                { data: 'creator_name', name: 'created_by.name' }
            );
        @endrole

        const table = $('#projects-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('projects.index') }}',
                type: 'GET'
            },
            columns: columns,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'Bf>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    extend: 'excel',
                    className: 'btn btn-success btn-sm',
                    text: '<i class="fas fa-file-excel"></i> Excel'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-danger btn-sm',
                    text: '<i class="fas fa-file-pdf"></i> PDF'
                },
                {
                    extend: 'print',
                    className: 'btn btn-info btn-sm',
                    text: '<i class="fas fa-print"></i> Print'
                }
            ],
            order: [[0, 'desc']],
            language: {
                search: '_INPUT_',
                searchPlaceholder: 'Search...',
            },
            responsive: true, // Crucial for making the table adapt to screen size
            autoWidth: false // Prevents DataTables from setting fixed widths based on initial content
        });

        // Handle delete button click
        $('#projects-table').on('click', '.delete-btn', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this project?')) {
                $(this).closest('form').submit();
            }
        });
    });
</script>
@endpush