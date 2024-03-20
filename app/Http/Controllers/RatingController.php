<?php

namespace App\Http\Controllers;

use App\Models\consultation;
use App\Models\rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(consultation $consultation){
        // dd($consultation);
        $ratings = rating::where('consultation_id', $consultation->id)->get();
        return view('rating.index', ['ratings' => $ratings], ['consultation' => $consultation]);
        
    }

    public function create(consultation $consultation){
        // dump($post->user_id);
        return view('rating.create', ['consultation' => $consultation]);

    }

    public function createRating(Request $request){
        try{
            $data = $request->validate([
                'consultation_id' => 'required',
                'student_id' => 'required',
                'counselor_id' => 'required',
                'review' => 'required',
                'rating'=> 'required'

            ]);
            $newRating= rating::create($data);
            if($newRating){
                return response()->json([
                    'success' => true,
                    'message' => 'Success add ratings',
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Failed add ratings',
                ]);
            }
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ]);
        }
    }


    public function store(Request $request, consultation $consultation){
        // dd($request);
        $rating = $request->stars;
        $data = $request->validate([
            'consultation_id' => 'required',
            'student_id' => 'required',
            'counselor_id' => 'required',
            'review' => 'required'
        ]);
        $data['rating'] = $rating;
        $newRating= Rating::create($data);
        return redirect(route('consultation.index'))->with('success', 'Rating Added Successfully!');
    }

    public function destroy(consultation $consultation, Rating $rating){
        // dd($consultation);
        $rating->delete();
        return redirect(route('consultation.index'))->with('success', 'Rating Deleted Successfully!');
    }
}
