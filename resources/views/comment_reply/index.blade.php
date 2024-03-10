@extends('backend.layout')

@section('title', 'Comment Replies')
@section('icon', 'comment-lines')

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<a href="{{ route('comment_reply.create', ['comment' => $comment]) }}" class="btn btn-primary">Add New Reply</a>
<h3>Post :</h3>
<div>{{ $comment->id }}</div>
<h1>{{ $comment->comment }}</h1>
<h3>Comments:</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Reply</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($comment_replies as $comment_reply)
            <tr>
                <td>{{ $comment_reply->id }}</td>
                <td>{{ $comment_reply->user_id }}</td>
                <td>{{ $comment_reply->reply }}</td>
                

                <td>
                    <form method="post" action="{{ route('comment_reply.destroy', ['comment_reply' => $comment_reply, 'comment' => $comment]) }}" style="display: inline-block;">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this reply?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection