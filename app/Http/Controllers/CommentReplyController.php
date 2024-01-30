<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\comment_reply;
use Illuminate\Http\Request;

class CommentReplyController extends Controller
{
    public function index(comment $comment){
        $comment_replies = comment_reply::where('comment_id', $comment->id)->get();
        return view('comment_reply.index', ['comment_replies' => $comment_replies], ['comment' => $comment]);
    }

    public function create(comment $comment){
        // dump($post->user_id);
        return view('comment_reply.create', ['comment' => $comment]);

    }


    public function store(Request $request, comment $comment){
        // dd($request);
        $data = $request->validate([
            'user_id' => 'required',
            'comment_id' => 'required',
            'post_id' => 'required',
            'reply' => 'required'
        ]);
    
        // $post = post::findOrFail($request->input('post_id'));
    
    
        $newComment = comment_reply::create($data);
    
        return redirect(route('comment_reply.index', ['comment' => $comment]))->with('success', 'Reply Added Successfully!');
    }

    public function destroy(comment_reply $comment_reply, comment $comment){
        $comment_reply->delete();
        return redirect(route('comment_reply.index', ['comment' => $comment]))->with('success', 'Reply Deleted Successfully');
    }
}
