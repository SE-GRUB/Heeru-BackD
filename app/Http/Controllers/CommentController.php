<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(){
        $comment = comment::all();
        return view('comment.index', ['comment' => $comment]);
        
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
    
        return redirect()->route('post.index')->with('success', 'Comment Added Successfully!');
    }


    public function edit(comment $comment){
        return view('comment.edit', ['comment' => $comment]);
    }

    public function update(comment $comment, Request $request){
        $data = $request->validate([
            'comment' => 'required'
        ]);

        $comment->update(($data));
        return redirect(route('comment.index'))->with('success', 'Comment Updated Successfully');
    }

    public function destroy(comment $comment){
        $comment->delete();
        return redirect(route('comment.index'))->with('success', 'Comment Deleted Successfully');
    }
}
