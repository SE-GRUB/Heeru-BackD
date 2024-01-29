@extends('backend.layout')

@section('title', 'Add Infographic')

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
        <form action="{{ route('infographic.store') }}" method="post">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("post")

            <div class="form-group">
                <label for="title">Infographic Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="infographic_images">Select Infographic Files:</label>
                <input type="file" class="form-control" id="infographic_images" name="infographic_images[]" multiple required>
            </div>

            <button type="submit" class="btn btn-primary">Add Infographic</button>
        </form>
    </div>
@endsection