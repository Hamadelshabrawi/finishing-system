@extends('layouts.app')

@section('title') Projects @endsection

@section('content')
    <h1>Projects</h1>
    @can('Create Project')
    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Create New Project</a>
    @endcan
    <table class="table table-bordered" id="projects-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Project Name</th>
                @if(auth()->check() && auth()->user()->hasRole('Admin'))
                    <th>Client</th>
                @endif
                <th>Quantity</th>
                <th>Delivery Date</th>
                <th>Actions</th>    
            </tr>
        </thead>
    </table>
@endsection

@push('scripts')
<!-- Include jQuery and DataTables scripts -->
<link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.4.1/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.10.0/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(function () {
    let columns = [
        { data: 'date', name: 'date' },
        { data: 'project_name', name: 'project_name' },
        { data: 'quantity', name: 'quantity' },
        { data: 'delivery_date', name: 'delivery_date' },
        { data: 'actions', name: 'actions', orderable: false, searchable: false }
    ];

    @if(auth()->check() && auth()->user()->hasRole('Admin'))
        columns.splice(2, 0, { data: 'client_name', name: 'client.name' });
    @endif

    $('#projects-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('projects.index') }}',
        columns: columns,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});
</script>
@endpush
