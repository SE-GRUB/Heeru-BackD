@extends('backend.layout')

@section('title', 'Edit Infographic')

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
        <form action="{{ route('infographic.update', ['infographic'=>$infographic])}}" method="post">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("put")

            <div class="form-group">
                <label for="title">Infographic Title:</label>
                <input type="text" class="form-control" id="title" name="title"  value="{{ $infographic->title }}" required>
            </div>


            <button type="submit" class="btn btn-primary">Edit Infographic</button>
        </form>
    </div>
@endsection