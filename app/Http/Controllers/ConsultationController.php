<?php

namespace App\Http\Controllers;

use App\Models\chat;
use App\Models\consultation;
use App\Models\consultation_result;
use App\Models\User;
use App\Models\video_call;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultationController extends Controller
{
    public function index(){
        $consultation = consultation::all();
        return view('consultation.index', ['consultation' => $consultation]);
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
            'note' => 'required',
        ]);
        $data['isPaid']=false;
        $newConsultation = consultation::create($data);
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

    public function destroy(consultation $consultation){
        $consultation_results=consultation_result::where('consultation_id', $consultation->id)->get();
        foreach($consultation_results as $consultation_result){
            $consultation_result->delete();
        }
        $chats = chat::where('consultation_id', $consultation->id)->get();
        foreach($chats as $chat){
            $chat->delete();
        }
        $video_calls=video_call::where('consultation_id', $consultation->id)->get();
        foreach($video_calls as $video_call){
            $video_call->delete();
        }
        $consultation->delete();
        return redirect(route('consultation.index'))->with('success', 'Consultation Deleted Successfully');
    }

    public function getSche(Request $request) {
        try {
            $time = DB::table('consultations')
            ->where('consultation_date', $request->input('time'))
            ->select('duration')
            ->get();
    
            return response()->json([
                'success' => true,
                'time' => $time,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
