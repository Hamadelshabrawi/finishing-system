@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ \App\Helpers\TranslationHelper::translate('suppliers.title') }}</h5>
                    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> {{ \App\Helpers\TranslationHelper::translate('suppliers.create.title') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ \App\Helpers\TranslationHelper::translate('suppliers.table.name') }}</th>
                                    <th>{{ \App\Helpers\TranslationHelper::translate('suppliers.table.location') }}</th>
                                    <th>{{ \App\Helpers\TranslationHelper::translate('suppliers.table.contact') }}</th>
                                    <th>{{ \App\Helpers\TranslationHelper::translate('suppliers.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $supplier->name }}</td>
                                        <td>{{ $supplier->location }}</td>
                                        <td>{{ $supplier->contact }}</td>
                                        <td>
                                            <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> {{ \App\Helpers\TranslationHelper::translate('suppliers.buttons.view') }}
                                            </a>
                                            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> {{ \App\Helpers\TranslationHelper::translate('suppliers.buttons.edit') }}
                                            </a>
                                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ \App\Helpers\TranslationHelper::translate('suppliers.delete.confirm') }}')">
                                                    <i class="fas fa-trash"></i> {{ \App\Helpers\TranslationHelper::translate('suppliers.buttons.delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
