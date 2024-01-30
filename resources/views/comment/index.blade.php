@extends('backend.layout')

@section('title', 'Comment')

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<a href="{{ route('comment.create', ['post' => $post]) }}" class="btn btn-primary">Add New Comment</a>
<h3>Post :</h3>
<div>{{ $post->id }}</div>
<h1>{{ $post->post_body }}</h1>
<h3>Comments:</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Comment</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($comments as $comment)
            <tr>
                <td>{{ $comment->id }}</td>
                <td>{{ $comment->user_id }}</td>
                <td>{{ $comment->comment }}</td>
                

                <td>
                    <form method="post" action="{{ route('comment.destroy', ['comment' => $comment, 'post' => $post]) }}" style="display: inline-block;">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection