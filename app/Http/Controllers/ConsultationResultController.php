<?php

namespace App\Http\Controllers;

use App\Models\consultation;
use App\Models\consultation_result;
use Illuminate\Http\Request;

class ConsultationResultController extends Controller
{
    public function index(consultation $consultations){
        $consultation_result = consultation_result::all();
        return view('consultation_result.index', ['consultation_result' => $consultation_result], ['consultations' => $consultations]);
    }

    public function create(consultation $consultations){
        // dump($post->user_id);
        return view('consultation_result.create', ['consultations' => $consultations]);

    }


    public function store(Request $request, consultation $consultations){
        // dd($request);
        $data = $request->validate([
            'user_id' => 'required',
            'comment_id' => 'required',
            'post_id' => 'required',
            'reply' => 'required'
        ]);
    
        // $post = post::findOrFail($request->input('post_id'));
    
    
        $newComment = consultation_result::create($data);
    
        return redirect(route('consultation_result.index', ['consultations' => $consultations]))->with('success', 'Result Added Successfully!');
    }

    public function destroy(consultation_result $consultation_results, consultation $consultations){
        $consultation_results->delete();
        return redirect(route('consultation_result.index', ['consultation' => $consultations]))->with('success', 'Reply Deleted Successfully');
    }
}
