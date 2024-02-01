@extends('backend.layout')

@section('title', 'Add Report Category')

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
        <form action="{{ route('report_category.store') }}" method="post">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("post")

            <div class="form-group">
                <label for="category_name">Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" required>
            </div>

            <div class="form-group">
                <label for="weight">Weight</label>
                <input type="number" class="form-control" id="weight" name="weight" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Report Categories</button>
        </form>
    </div>

@endsection