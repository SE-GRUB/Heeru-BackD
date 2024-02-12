@extends('backend.layout')

@section('title', 'Add Consultation')
@section('icon', 'heart')

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
        <form action="{{ route('consultation.store') }}" method="post">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("post")

            <div class="form-group">
                <label for="student_id">Student:</label>
                <select class="form-control" id="student_id" name="student_id" required>
                    @foreach($users as $user)
                        @if($user->role === 'student')
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="user_id">Counselor:</label>
                <select class="form-control" id="counselor_id" name="counselor_id" required>
                    @foreach($users as $user)
                        @if($user->role === 'counselor')
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="consultation_date">Consultation Date:</label>
                <input type="date" class="form-control" id="consultation_date" name="consultation_date" required>
            </div>

            <div class="form-group">
                <label for="duration">Duration:</label>
                <input type="number" class="form-control" id="duration" name="duration" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Post</button>
        </form>
    </div>
@endsection