@extends('backend.layout')

@section('title', 'Add Comment')
@section('icon', 'comment-lines')

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
        <form action="{{ route('comment_reply.store', ['comment' => $comment]) }}" method="post" enctype="multipart/form-data">
            <!-- CSRF Token for Laravel -->
            @csrf
            @method("post")
            <input type="hidden" name="user_id" value="{{ $comment->user_id }}">
            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
            <input type="hidden" name="post_id" value="{{ $comment->post_id }}">

            <div class="form-group">
                <label for="reply">Comment_reply :</label>
                <input type="text" class="form-control" id="reply" name="reply" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Reply</button>
        </form>
    </div>
@endsection