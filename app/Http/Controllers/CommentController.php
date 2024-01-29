<?php

namespace App\Http\Controllers;

use App\Models\comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(){
        $comment = comment::all();
        return view('comment.index', ['comment' => $comment]);
        
    }

    public function create(){
        return view('comment.create');
    }


    public function store(Request $request){
        
        $data = $request->validate([
            'comment' => 'required'
        ]);

        // simpan data ke Infographic
        $newInfographic = comment::create($data);
        return redirect((route(('comment.index'))))->with('success', 'Comment Added Successfully !');;
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
