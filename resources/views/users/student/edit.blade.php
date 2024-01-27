@extends('backend.layout')

@section('title', 'Edit User')

@section('content')
    <div class="container mt-5">
        <h2>Edit Student</h2>
        <div>
            @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
            @endif
        </div>
        <form action="{{ route('user.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="role">Role:</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="student" selected>Student</option>
                    <option value="pic">PIC</option>
                    <option value="counselor">Counselor</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="program_id">Program:</label>
                <select class="form-control" id="program_id" name="program_id">
                    <option value="1">Program 1</option>
                    <option value="2">Program 2</option>
                </select>
            </div>

            <div class="form-group">
                <label for="nip">NIP:</label>
                <input type="number" class="form-control" id="nip" name="nip">
            </div>

            <div class="form-group">
                <label for="no_telp">Phone Number:</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>

            <button type="submit" class="btn btn-primary">Edit User</button>
        </form>
    </div>

@endsection