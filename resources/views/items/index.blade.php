@extends('layouts.app')

@section('title', 'Items List')


@section('content')
    <h1>Items</h1>
    <a href="{{ route('items.create') }}" class="btn btn-primary mb-3">Add New Item</a>

    <table class="table table-bordered" id="projects-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Unit</th>
                <th>Total Stock</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
    </table>
@endsection

@push('scripts')

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
        { 
            data: null, 
            name: 'id', 
            render: function (data, type, row, meta) {
                return meta.row + 1; // Incremental index
            }
        },
        { data: 'name', name: 'name' },
        { data: 'unit', name: 'unit' },
        { data: 'description', name: 'description' },
        { data: 'actions', name: 'actions', orderable: false, searchable: false }
    ];

    $('#projects-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('items.index') }}',
        columns: columns,
        order: [[0, 'desc']],
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});
</script>
@endpush
