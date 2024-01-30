<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(post $post){
        $comments = comment::all();
        return view('comment.index', ['comments' => $comments], ['post' => $post]);
        
    }

    public function create(post $post){
        // dump($post->user_id);
        return view('comment.create', ['post' => $post]);

    }


    public function store(Request $request, post $post){
        // dd($request);
        $data = $request->validate([
            'user_id' => 'required',
            'post_id' => 'required',
            'comment' => 'required'
        ]);
    
        // $post = post::findOrFail($request->input('post_id'));
    
    
        $newComment = Comment::create($data);
    
        return redirect(route('comment.index', ['post' => $post]))->with('success', 'Comment Added Successfully!');
    }

    public function destroy(comment $comment, post $post){
        $comment->delete();
        return redirect(route('comment.index', ['post' => $post]))->with('success', 'Comment Deleted Successfully');
    }
}
