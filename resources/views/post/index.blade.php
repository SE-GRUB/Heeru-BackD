@extends('backend.layout')

@section('title', 'Posts')
@section('icon', 'postcard')

@section('button')
    <a href="{{ route('post.create') }}" class="btn btn-primary">Add New Post</a>
@endsection

@section('content')

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Post Body</th>
            <th>Poster</th>
            <th>Like</th>
            <th>Is Anonymous</th>
            <th>Is Verified</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->user_id }}</td>
                <td>{{ $post->post_body }}</td>
                <td>{{ $post->poster }}</td>
                <td>{{ $post->like }}</td>
                <td>{{ $post->isAnonymous ? 'Yes' : 'No' }}</td>
                <td>{{ $post->isVerified ? 'Yes' : 'No' }}</td>
                

                <td>
                    <a href="{{ route('post.edit', ['post' => $post]) }}" class="btn btn-primary">Edit</a>
                    <form method="post" action="{{ route('post.destroy', ['post' => $post]) }}" style="display: inline-block;">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                    </form>
                    <a href="{{ route('comment.index',  ['post' => $post])}}" class="btn btn-primary">View Comment</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection