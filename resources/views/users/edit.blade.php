@extends('backend.layout')

@section('title', 'Edit User')
@section('icon', 'user')

@section('content')
    <div class="container mt-5">
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('user.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>

            <div class="form-group">
                <label for="role">Role:</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="pic" {{ $user->role == 'pic' ? 'selected' : '' }}>PIC</option>
                    <option value="counselor" {{ $user->role == 'counselor' ? 'selected' : '' }}>Counselor</option>
                </select>
            </div>
            
            <div id="studentFields">
                <div class="form-group">
                    <label for="program_id">Program:</label>
                    <select class="form-control" id="program_id" name="program_id">
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ $user->program_id == $program->id ? 'selected' : '' }}>
                                {{ $program->program_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>            

            <div id="picFields">
                <div class="form-group">
                    <label for="nip">NIP:</label>
                    <input type="number" class="form-control" id="nip" name="nip" value="{{ $user->nip }}">
                </div>
            </div>

            <div id="counselorFields" style="display:none">
                <div class="form-group">
                    <label for="fare">Fare:</label>
                    <input type="number" class="form-control" id="fare" name="fare" value="{{ $user->fare }}">
                </div>
            </div>

            <div class="form-group">
                <label for="no_telp">Phone Number:</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{ $user->no_telp }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
            </div>

            <button type="submit" class="btn btn-primary">Edit User</button>
        </form>
    </div>

@endsection