<?php

namespace App\Http\Controllers;

use App\Models\consultation;
use App\Models\User;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index(){
        $consultations = consultation::all();
        return view('consultation.index', ['consultations' => $consultations]);
    }

    public function create(){
        $users = User::all();
        return view('consultation.create', ['users' => $users]);
    }

    public function store(Request $request){
        // dd($request);
        $data = $request->validate([
            'student_id' => 'required',
            'counselor_id' => 'required',
            'consultation_date' => 'required',
            'duration' => 'required',
        ]);
       
        $newPost = consultation::create($data);
        return redirect((route(('consultation.index'))))->with('success', 'Consultation Added Successfully !');;
    }


    // public function edit(consultation $consultation){
    //     $users = consultation::all();
    //     return view('post.edit', ['post' => $post], ['users' => $users]);
    // }

    // public function update(post $post, Request $request){
    //     $data = $request->validate([
    //         'user_id' => 'required',
    //         'post_body' => 'required',
    //     ]);
    //     $data['isAnonymous'] = $request->input('isAnonymous', false);
    //     $post->update(($data));
    //     return redirect(route('post.index'))->with('success', 'Post Updated Successfully');
    // }

    public function destroy(consultation $consultations){
        $consultations->delete();
        return redirect(route('consultation.index'))->with('success', 'Consultation Deleted Successfully');
    }
}
