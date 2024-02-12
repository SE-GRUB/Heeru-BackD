@extends('backend.layout')

@section('title', 'Edit Report Category')
@section('icon', 'folder')

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
        <form action="{{route('report_category.update', ['report_category'=>$report_category])}}" method="post">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("put")

            <div class="form-group">
                <label for="category_name">Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $report_category->category_name }}" required>
            </div>

            <div class="form-group">
                <label for="weight">Weight</label>
                <input type="number" class="form-control" id="weight" name="weight" required>
            </div>

            <button type="submit" class="btn btn-primary">Edit Report Categories</button>
        </form>
    </div>

@endsection