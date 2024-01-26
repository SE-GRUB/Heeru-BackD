<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function checkuser(Request $request){
        $nip = $request->input('nip');
        $user = DB::table('users')
                ->join('students', 'students.user_id', '=', 'users.id')
                ->join('pics', 'pics.user_id', '=', 'users.id')
                ->where('students.nip', $nip)
                ->orWhere('pics.nip', $nip)
                ->first();

        if ($user) {
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }
    }
}
