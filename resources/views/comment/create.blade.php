@extends('backend.layout')

@section('title', 'Add Comment')

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
        <form action="{{ route('comment.store', ['post' => $post]) }}" method="post" enctype="multipart/form-data">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("post")
            <input type="hidden" name="user_id" value="{{ $post->user_id }}">
            <input type="hidden" name="post_id" value="{{ $post->id }}">

            <div class="form-group">
                <label for="comment">Comment :</label>
                <input type="text" class="form-control" id="comment" name="comment" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Comment</button>
        </form>
    </div>
@endsection