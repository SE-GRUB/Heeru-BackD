<?php

namespace App\Http\Controllers;

use App\Models\consultation;
use App\Models\consultation_result;
use Illuminate\Http\Request;

class ConsultationResultController extends Controller
{
    public function index(consultation $consultation){
        $consultation_result = consultation_result::where('consultation_id', $consultation->id)->get();
        return view('consultation_result.index', ['consultation_result' => $consultation_result], ['consultation' => $consultation]);
    }

    public function create(consultation $consultation){
        // dump($post->user_id);
        return view('consultation_result.create', ['consultation' => $consultation]);

    }


    public function store(Request $request, consultation $consultation){
        // dd($request);
        $data = $request->validate([
            'student_id' => 'required',
            'counselor_id' => 'required',
            'consultation_id' => 'required',
            'note' => 'required'
        ]);
    
        // $post = post::findOrFail($request->input('post_id'));
    
        
        $newComment = consultation_result::create($data);
    
        return redirect(route('consultation_result.index', ['consultation' => $consultation]))->with('success', 'Result Added Successfully!');
    }

    public function edit(consultation_result $consultation_result, consultation $consultation){
        return view('consultation_result.edit', ['consultation_result' => $consultation_result], ['consultation' => $consultation]);
    }

    public function update(consultation_result $consultation_result, Request $request, consultation $consultation){
        $data = $request->validate([
            'note' => 'required'
        ]);

        $consultation_result->update(($data));
        return redirect(route('consultation_result.index',  ['consultation' => $consultation]))->with('success', 'Result Updated Successfully');
    }

    public function destroy(consultation_result $consultation_result, consultation $consultation){
        $consultation_result->delete();
        return redirect(route('consultation_result.index', ['consultation' => $consultation]))->with('success', 'Reply Deleted Successfully');
    }
}
