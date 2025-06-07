@extends('layouts.app')

@section('title')
Clients 
@endsection

@section('content')
    <h1>Clients</h1>

    @can('Create Client')
        <div class="text-end mb-3">
            <a href="{{ route('clients.create') }}" class="btn btn-success rounded-pill">Create Client</a>
        </div>
    @endcan

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered" id="clientsTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Company</th>
                <th>Address</th>
                <th>Tax Number</th>
                <th>Commercial Reg.</th>
                <th>Type</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
    </table>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {
    $('#clientsTable').DataTable({
        dom: '<"top"Bfrtip<"clear">>',
        buttons: [
            {
                extend: 'copy',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude actions column
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude actions column
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude actions column
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude actions column
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:not(:last-child)' // Exclude actions column
                }
            },
            'colvis' // Column visibility button
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('clients.index') }}",
            type: 'GET'
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'company_name', name: 'company_name' },
            { data: 'address', name: 'address' },
            { data: 'tax_number', name: 'tax_number' },
            { data: 'commercial_registration_number', name: 'commercial_registration_number' },
            { data: 'type', name: 'type' },
            { 
                data: 'created_at', 
                name: 'created_at',
                render: function(data) {
                    return data ? new Date(data).toLocaleString() : '';
                }
            },
            { 
                data: 'actions', 
                name: 'actions',
                orderable: false, 
                searchable: false,
                exportable: false
            }
        ],
        responsive: true,
        columnDefs: [
            { responsivePriority: 1, targets: 0 }, // Name
            { responsivePriority: 2, targets: 1 }, // Email
            { responsivePriority: 3, targets: 2 }, // Phone
            { responsivePriority: 4, targets: 3 }, // Company name
            { responsivePriority: 5, targets: -1 }, // Actions
            { targets: [4,5,6,7], visible: false }, // Hide address, tax number, etc. by default
            { targets: 8, visible: false } // Hide 'created_at' column for mobile
        ],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
        }
    });

    // Delete confirmation
    $('#clientsTable').on('click', '.btn-danger', function(e) {
        if (!confirm('Are you sure you want to delete this client?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
