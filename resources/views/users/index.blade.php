@extends('backend.layout')

@section('title', 'User')
@section('icon', 'user')

@section('button')
    <a href="{{ route('user.create', ['role' => $role]) }}" class="btn btn-primary">Add New User</a>
@endsection

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<div>
    <!-- Button for Administrator -->
    <a href="{{ route('user.index', ['role' => 'admin']) }}" class="btn btn-{{ $role == 'admin' ? 'success' : 'primary' }}">View Administrator's</a>
    <!-- Button for PIC -->
    <a href="{{ route('user.index', ['role' => 'pic']) }}" class="btn btn-{{ $role == 'pic' ? 'success' : 'primary' }}">View PIC's</a>
    <!-- Button for Student -->
    <a href="{{ route('user.index', ['role' => 'student']) }}" class="btn btn-{{ $role == 'student' ? 'success' : 'primary' }}">View Student's</a>
</div>
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