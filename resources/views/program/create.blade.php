@extends('backend.layout')

@section('title', 'Add Program')

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
        <form action="{{ route('program.store') }}" method="post">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("post")

            <div class="form-group">
                <label for="program_name">Program Name:</label>
                <input type="text" class="form-control" id="program_name" name="program_name" required>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Program</button>
        </form>
    </div>
@endsection