@extends('backend.layout')

@section('title', 'User')

@section('content')

<div>
    @if(session()->has('success'))
    <div>
        {{ session('success') }}
    </div>
    @endif
</div>
<a href="{{ route('user.create') }}" class="btn btn-primary">Add New User</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Loop through your users data and populate the table rows -->
        @foreach($usersAndRoles as $item)
            <tr>
                <td>{{ $item->user->id }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->user->no_telp }}</td>
                <td>{{ $item->user->email }}</td>
                @foreach($item->roles as $role)
                    <td>{{ $role->role }}</td>
                 @endforeach
                <td>
                    @foreach($item->roles as $role)
                        if({{ $role->role }} == 'students'){
                            <a href="{{ route('user.editStudent', ['user' => $item->user]) }}" class="btn btn-primary">Edit</a>
                        }
                    @endforeach
                    <form method="post" action="{{ route('user.destroy', ['user' => $item->user]) }}" style="display: inline-block;">
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