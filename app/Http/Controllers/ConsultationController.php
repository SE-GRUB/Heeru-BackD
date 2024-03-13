<?php

namespace App\Http\Controllers;

use App\Models\chat;
use App\Models\consultation;
use App\Models\consultation_result;
use App\Models\rating;
use App\Models\User;
use Carbon\Carbon;
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
        // dd($request);

        try{
            $consultation_id = $request->query('id');

            // $result = consultation::find($consultation_id);
            // $student = User::where('id', $result->student_id);
            // $counselor = User::where('id', $result->counselor_id);
            // $payment = payment::where('consultation_id', $consultation_id);
            $data = DB::table("DataKonsultasi")->where('id', $consultation_id)->first();
            // dd($data);


            if($data){
                $resultarray = [
                    'note' =>$data->note?$data->note:'',
                    'consultation_date' => $data->consultation_date,
                    'consultation_id' => $data->id,
                    'counselor_profile' => $data->dokter_profile_pic,
                    'counselorName' => $data->dokter_name,
                    // 'paymentMethod' => $data->payment_method_name,
                    'paymentNominal' => $data->dokter_fare,
                    'time' => $data->created_at

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

    public  function updateConsultation(Request $request, $user_id){

    }

    public function konsulOngoing(Request $request){
        try {
            $consultations = consultation::select('consultations.id', 'users.name', 'consultations.isPaid', 'consultations.consultation_date', 'consultations.duration')
                ->join('users', 'consultations.counselor_id', '=', 'users.id')
                ->where('consultations.student_id', $request->input('user_id'))
                ->where('consultations.consultation_date', '>=', Carbon::now()->startOfDay())
                ->whereNull('consultations.note')
                ->orderBy('consultations.consultation_date')
                ->get();
                $consultationData = [];
                foreach ($consultations as $consultation) {
                    switch ($consultation->duration) {
                        case '0':
                            $statusText = "Off";
                            break;
                        case '1':
                            $statusText = "08:00-09:00";
                            break;
                        case '2':
                            $statusText = "09:00-10:00";
                            break;
                        case '3':
                            $statusText = "10:00-11:00";
                            break;
                        case '4':
                            $statusText = "11:00-12:00";
                            break;
                        case '5':
                            $statusText = "13:00-14:00";
                            break;
                        case '6':
                            $statusText = "14:00-15:00";
                            break;
                        case '7':
                            $statusText = "15:00-16:00";
                            break;
                        case '8':
                            $statusText = "16:00-17:00";
                            break;
                        case '9':
                            $statusText = "17:00-18:00";
                            break;
                        case '10':
                            $statusText = "18:00-19:00";
                            break;
                        default:
                            $statusText = "No value found";
                    }
                    $result = calculateTimeUntilConsultationStarts($statusText, $consultation->consultation_date);
                    $minutesUntilConsultationStarts = $result['diff'];
                    $end = $result['end'];
                    $currentTime = Carbon::now();
                    if ($minutesUntilConsultationStarts >= 0 OR $currentTime < $end) {
                        if($minutesUntilConsultationStarts < 0){
                            $consultation['endIn'] = $end->diffInMinutes($currentTime);
                        }
                        $consultation['time'] = $minutesUntilConsultationStarts;
                        $consultationData[] = $consultation;
                    } 
                }
            return response()->json([
                'success' => true,
                'message' => 'Fetched ongoing consultations!',
                'consultations' => $consultationData
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => False,
                'message' => 'Internal server error',
                'error' => $th->getMessage()
            ]);
        }
    }
    public function konsulDone(Request $request){
        try {
            $consultations = consultation::select('consultations.id', 'users.name', 'consultations.isPaid', 'consultations.consultation_date', 'consultations.duration')
                ->join('users', 'consultations.counselor_id', '=', 'users.id')
                ->where('consultations.student_id', $request->input('user_id'))
                ->where('consultations.consultation_date', '<=', Carbon::now()->startOfDay())
                ->orderBy('consultations.consultation_date')
                ->get();
                $consultationData = [];
                foreach ($consultations as $consultation) {
                    switch ($consultation->duration) {
                        case '0':
                            $statusText = "Off";
                            break;
                        case '1':
                            $statusText = "08:00-09:00";
                            break;
                        case '2':
                            $statusText = "09:00-10:00";
                            break;
                        case '3':
                            $statusText = "10:00-11:00";
                            break;
                        case '4':
                            $statusText = "11:00-12:00";
                            break;
                        case '5':
                            $statusText = "13:00-14:00";
                            break;
                        case '6':
                            $statusText = "14:00-15:00";
                            break;
                        case '7':
                            $statusText = "15:00-16:00";
                            break;
                        case '8':
                            $statusText = "16:00-17:00";
                            break;
                        case '9':
                            $statusText = "17:00-18:00";
                            break;
                        case '10':
                            $statusText = "18:00-19:00";
                            break;
                        default:
                            $statusText = "No value found";
                    }
                    $minutesUntilConsultationStarts = calculateTimeUntilConsultationStarts($statusText, $consultation->consultation_date)['diff'];
                    if ($minutesUntilConsultationStarts < 0) {
                        $rating = rating::where('consultation_id', $consultation->id)->first();
                        if ($rating) {
                            $consultation['rating'] = $rating->rating;
                        } else {
                            $consultation['rating'] = '0';
                        }
                        $consultationData[] = $consultation;
                    }
                }
                
            return response()->json([
                'success' => true,
                'message' => 'Fetched done consultations!',
                'consultations' => $consultationData
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => False,
                'message' => 'Internal server error',
                'error' => $th->getMessage()
            ]);
        }
    }
}
function calculateTimeUntilConsultationStarts($statusText, $consultationDate){
    list($startTime, $endTime) = explode('-', $statusText);
    $consultationDateTime = Carbon::createFromFormat('Y-m-d H:i', $consultationDate . ' ' . $startTime);
    $consultationEndDateTime = Carbon::createFromFormat('Y-m-d H:i', $consultationDate . ' ' . $endTime);
    $currentTime = Carbon::now();
    if ($currentTime > $consultationDateTime) {
        $diffInMinutes = -$consultationDateTime->diffInMinutes($currentTime);
    }else{
        $diffInMinutes = $consultationDateTime->diffInMinutes($currentTime);
    }
    return [
        'start' => $consultationDateTime,
        'end' => $consultationEndDateTime,
        'diff' => $diffInMinutes
    ];
}