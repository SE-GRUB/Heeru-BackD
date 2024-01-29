<?php

namespace App\Http\Controllers;

use App\Models\like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
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
