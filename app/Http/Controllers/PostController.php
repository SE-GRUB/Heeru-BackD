<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts = post::all();
        return view('post.index', ['posts' => $posts]);
    }

    public function create(){
        $users = User::all();
        return view('post.create', ['users' => $users]);
    }

    public function store(Request $request){
        // dd($request);
        $data = $request->validate([
            'user_id' => 'required',
            'post_body' => 'required',
        ]);
        $data['like'] = 0;
        $data['isVerified'] = false;
        $data['isAnonymous'] = $request->input('isAnonymous', false);
        $newPost = post::create($data);
        return redirect((route(('post.index'))))->with('success', 'Post Added Successfully !');;
    }


    public function edit(post $post){
        $users = User::all();
        return view('post.edit', ['post' => $post], ['users' => $users]);
    }

    public function update(post $post, Request $request){
        $data = $request->validate([
            'user_id' => 'required',
            'post_body' => 'required',
        ]);
        $data['isAnonymous'] = $request->input('isAnonymous', false);
        $post->update(($data));
        return redirect(route('post.index'))->with('success', 'Post Updated Successfully');
    }

    public function destroy(post $post){
        $post->delete();
        return redirect(route('post.index'))->with('success', 'Post Deleted Successfully');
    }
}
