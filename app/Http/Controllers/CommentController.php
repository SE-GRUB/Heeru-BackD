<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\comment;
use App\Models\post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(post $post){
        $comments = comment::where('post_id', $post->id)->get();
        return view('comment.index', ['comments' => $comments], ['post' => $post]);
        
    }

    public function create(post $post){
        // dump($post->user_id);
        return view('comment.create', ['post' => $post]);
    }


    public function store(Request $request, post $post){
        // dd($request);
        $data = $request->validate([
            'post_id' => 'required',
            'comment' => 'required'
        ]);
        $data['user_id'] = Auth::user()->id;
        $newComment = Comment::create($data);
        return redirect(route('post.index'));
        // return redirect(route('comment.index', ['post' => $post]))->with('success', 'Comment Added Successfully!');
    }

    public function destroy(comment $comment){
        $comment->delete();
        return redirect(route('post.index'));
        // return redirect(route('comment.index', ['post' => $post]))->with('success', 'Comment Deleted Successfully');
    }
}
