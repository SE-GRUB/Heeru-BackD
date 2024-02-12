@extends('backend.layout')

@section('title', 'Add Post')
@section('icon', 'postcard')

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
        <form action="{{ route('post.store') }}" method="post">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("post")

            <div class="form-group">
                <label for="user_id">User:</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="post_body">Post Body:</label>
                <textarea class="form-control" id="post_body" name="post_body" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <input type="checkbox" class="form-check-input" id="isAnonymousCheckbox" name="isAnonymous" value="1">
                <label for="isAnonymous">Anonymous</label>
            </div>

            <button type="submit" class="btn btn-primary">Add Post</button>
        </form>
    </div>
@endsection