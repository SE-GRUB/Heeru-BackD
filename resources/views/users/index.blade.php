@extends('backend.layout')

@section('title', 'User')
@section('icon', 'user')

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<a href="{{ route('user.create') }}" class="btn btn-primary">Add New User</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>NIP</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Loop through your users data and populate the table rows -->
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->nip }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->no_telp }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <a href="{{ route('user.edit', ['user' => $user]) }}" class="btn btn-primary">Edit</a>
                    <form method="post" action="{{ route('user.destroy', ['user' => $user]) }}" style="display: inline-block;">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection