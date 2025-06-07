@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
    
    @can('Create User')
        <div class="text-end mb-3">
            <a href="{{ route('users.create') }}" class="btn btn-success rounded-pill">Create User</a>
        </div>
    @endcan

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                @canany(['Edit User', 'Delete User'])
                <th>Actions</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->type) }}</td>
                    <td>
                        @can('Edit User')
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('Delete User')
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection