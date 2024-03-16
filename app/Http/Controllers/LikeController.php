<?php

namespace App\Http\Controllers;

use App\Models\like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request){
        $data = $request->validate([
            'post_id' => 'required',
            'user_id' => 'required',
            'action' => 'required'
        ]);

        if($data['action'] == 'like'){
            $newLike = like::create([
                'post_id'=> $data['post_id'],
                'user_id' => $data['user_id'] 
            ]);
            if($newLike){
                $jumlahlike = like::where('post_id', $data['post_id'])->count();
                return response()->json([
                    'success' => true,
                    'message' => 'Liked successfully',
                    'likeCount' => $jumlahlike
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Like failed',
                ]);
            }
        }else{
            $like = like::where('post_id', $data['post_id'])->where('user_id'  ,$data['user_id'])->first();
            $deleted = $like->delete();
            if($deleted){
                $jumlahlike = like::where('post_id', $data['post_id'])->count();
                return response()->json([
                    'success' => true,
                    'message' => 'Like deleted successfully',
                    'likeCount' => $jumlahlike
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Unlike failed',
                ]);
            }
        }
    }
    
    public function store(Request $request){
        $data = $request->validate([
            'user_id' => 'required',
            'post_id' => 'required',
        ]);
        $newLike = like::create($data);
        return response()->json(['done' => true, 'message' => 'Liked!'], 201);
    }

    public function destroy(like $like){
        $like->delete();
        return response()->json(['done' => true, 'message' => 'Unlike'], 201);
    }
}
