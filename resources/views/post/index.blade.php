@extends('backend.layout')

@section('title', 'Posts')
@section('icon', 'postcard')

@section('button')
    <a href="{{ route('post.create') }}" class="btn btn-primary">Add New Post</a>
@endsection

@section('content')
<style>
    /* Main post container */
    .post {
        border: 1px solid #ccc;
        margin-bottom: 20px;
        padding: 10px;
    }

    /* Post header */
    .post-header {
        display: flex;
        justify-content: space-between;
    }

    /* Post body */
    .post-body {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    /* Post footer */
    .post-footer {
        margin-top: 10px;
    }

    /* Comments container */
    .comments {
        margin-top: 10px;
    }

    /* Comment container */
    .comment {
        border: 1px solid #ddd;
        margin-top: 10px;
        padding: 5px;
    }

    /* Comment header */
    .comment-header {
        margin-bottom: 5px;
    }

    /* Comment body */
    .comment-body {
        margin-bottom: 5px;
    }

    /* Comment footer */
    .comment-footer {
        margin-top: 5px;
    }

    /* Circular profile picture */
    .pp {
        width: 40px;
        height: 40px;
        border-radius: 50%; /* Make it circular */
        margin-right: 10px; /* Add spacing */
    }

    .comment-replies {
        margin-top: 5px;
        margin-left: 20px; /* Indent replies */
    }

    .comment-reply {
        border: 1px solid #e5e5e5;
        margin-top: 5px;
        padding: 5px;
    }

    .reply-header {
        margin-bottom: 5px;
    }

    .reply-body {
        margin-bottom: 5px;
    }

    .reply-footer {
        margin-top: 5px;
    }

    .add-comment,
    .add-reply {
        display: none;
    }

    .tag {
    background-color: #f0f0f0; 
    border-radius: 4px; 
    padding: 2px 6px;
    color: #333;
    font-weight: bold; 
}
</style>

<div>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>

@foreach($posts as $post)
    <div class="post">
        <div class="post-header">
            <div class="poster">
                <img src="{{ $post['profile_pic'] }}" class="pp" alt="Poster Image">
                <span>{{ $post['name'] }}</span>
            </div>
            <div class="like-count">{{ $post['like'] }} Likes</div>
        </div>
        <div class="post-body">
            {{ $post['post_body'] }}
        </div>
        <div class="post-footer">
            <a href="#" class="add-comment-btn uil uil-corner-up-left-alt"></a>
            <a href="{{ route('post.edit', ['post' => $post['id']]) }}" class="uil uil-edit"></a>
            <form id="deleteForm{{ $post['id'] }}" method="post" action="{{ route('post.destroy', ['post' => $post['id']]) }}" style="display: inline-block;">
                @csrf
                @method("DELETE")
            </form>
            <a href="#" class="uil uil-trash-alt" onclick="confirmAndSubmitPost('{{ $post['id'] }}')"></a>
        </div>
        <!-- Form for adding a new comment -->
        <div class="add-comment">
            <form method="post" action="{{ route('comment.store', ['post' => $post['id']]) }}">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post['id'] }}">
                <div class="form-group">
                    <label for="comment">Add a comment:</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Comment</button>
            </form>
        </div>
        <div class="comments">
            @foreach($post['comments'] as $comment)
                <div class="comment">
                    <div class="comment-header">
                        <div class="commenter">
                            <img src="{{ $comment['profile_pic'] }}" class="pp" alt="Commenter Image">
                            <span>{{ $comment['user'] }}</span>
                        </div>
                    </div>
                    <div class="comment-body">
                        {{ $comment['comment'] }}
                    </div>
                    <div class="comment-footer">
                        <a class="add-reply-btn uil uil-corner-up-left-alt"></a>
                        <form id="deleteCommentForm{{ $comment['id'] }}" method="post" action="{{ route('comment.destroy', ['comment' => $comment['id']]) }}" style="display: inline-block;">
                            @csrf
                            @method("DELETE")
                        </form>
                        <a href="#" class="uil uil-trash-alt" onclick="confirmAndSubmitComment('{{ $comment['id'] }}')"></a>
                    </div>
                    <div class="comment-replies">
                        @foreach($comment['replies'] as $reply)
                            <div class="comment-reply">
                                <div class="reply-header">
                                    <div class="replier">
                                        <img src="{{ $reply['profile_pic'] }}" class="pp" alt="Replier Image">
                                        {{ $reply['replier'] }}
                                    </div>
                                </div>
                                <div class="reply-body">
                                    <span class="tag">{{ '@' . $comment['user'] }}</span> {{ $reply['reply_body'] }}
                                </div>                                
                                <div class="reply-footer">
                                    <form id="deleteReplyForm{{ $reply['id'] }}" method="post" action="{{ route('comment_reply.destroy', ['comment_reply' => $reply['id'], 'comment' => $comment['id']]) }}" style="display: inline-block;">
                                        @csrf
                                        @method("DELETE")
                                    </form>
                                    <a href="#" class="uil uil-trash-alt" onclick="confirmAndSubmitReply('{{ $reply['id'] }}')"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Form for adding a new reply -->
                    <div class="add-reply">
                        <form method="post" action="{{ route('comment_reply.store', ['post' => $post['id'], 'comment' => $comment['id']]) }}">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post['id'] }}">
                            <input type="hidden" name="comment_id" value="{{ $comment['id'] }}">
                            <div class="form-group">
                                <label for="reply">Add a reply:</label>
                                <textarea class="form-control" id="reply" name="reply" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Reply</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach
@endsection
<script>
    function confirmAndSubmitPost(postId) {
        if (confirm('Are you sure you want to delete this post?')) {
            document.getElementById('deleteForm' + postId).submit();
        }
    }

    function confirmAndSubmitComment(commentId) {
        if (confirm('Are you sure you want to delete this comment?')) {
            document.getElementById('deleteCommentForm' + commentId).submit();
        }
    }

    function confirmAndSubmitReply(replyId) {
        if (confirm('Are you sure you want to delete this reply?')) {
            document.getElementById('deleteReplyForm' + replyId).submit();
        }
    }
</script>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.add-reply-btn').click(function() {
            $(this).closest('.comment-footer').siblings('.add-reply').toggle();
        });

        $('.add-comment-btn').click(function(e) {
            e.preventDefault(); // Prevent the default action of the anchor tag
            $(this).closest('.post-footer').siblings('.add-comment').toggle(); // Toggle the visibility of the form
        });
    });
</script>
@endpush
