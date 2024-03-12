<?php

namespace App\Http\Controllers;

use App\Models\chat;
use App\Models\consultation;
use App\Models\consultation_result;
use App\Models\User;
use App\Models\Rating;
use App\Models\video_call;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    // get specific consultation
    public function myconsultation(Request $request) {
        try {
           $consultation = DB::table('DataKonsultasi')
           ->where('student_id', $request->input('id'))
           ->orderBy('consultation_date', 'asc')
           ->get();
            

            return response()->json([
                'success' => true,
                'consultation' => $consultation,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function getResult(Request $request){
        try{
            $consultation_id = $request->input('consultation_id');

            $result = consultation::find($consultation_id);
            $student = User::where('id', $result->student_id);
            $counselor = User::where('id', $result->counselor_id);


            if($result){
                $resultarray = [
                    'note' =>$result->note,
                    'consultation_date' => $result->consultation_date,
                    'consultation_id' => $result->id,
                    'student_profile' => $student->profile_pic,
                    'studentName' => $student->name,
                    'counselor_profile' => $counselor->profile_pic,
                    'counselorName' => $counselor->name,
                ];


                return response()->json([
                    'success' => true,
                    'message' => 'fetch consultation result successfully',
                    'result' => $resultarray,
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'result not found!',
                ]);
            }

        }catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => $th->getMessage(),
            ]);
        }
    
    }
}
