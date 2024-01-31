<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\program;

function generateNIP() {
    $nip = 'C-';
    for ($i = 0; $i < 6; $i++) {
        $nip .= mt_rand(0, 9);
    }
    return $nip;
}

class UserController extends Controller
{
    public function checkuser(Request $request){
        try {
            $nip = $request->input('nip');
            $user = DB::table('users')
                    ->where('users.nip', $nip)
                    ->first();

            if ($user) {
                return response()->json(['user' => $user]);
            }else{
                return response()->json(['message' => 'User tidak ditemukan'], 302);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Internal server error'], 500);

        }
    }

    public function index(){
        $users = User::all();
        return view('users.index', ['users' => $users]);
        
    }

    public function create(){
        $programs = program::all();
        return view('users.create', ['programs' => $programs]);
    }   

    public function store(Request $request){
        if ($request['role'] == 'student') {
            // dd('User is Student');
            $data = $request->validate([
                'name' => 'required',
                'role' => 'required',
                'no_telp' => 'required|unique',
                'email' => 'required',
                'program_id' => 'required',
                'nip' => 'required|numeric',
            ]);
        } else if ($request['role'] == 'pic') {
            // dd('User is PIC');
            $data = $request->validate([
                'name' => 'required',
                'role' => 'required',
                'no_telp' => 'required|unique',
                'email' => 'required',
                'nip' => 'required|numeric',
            ]);
        } else {
            // dd('User is Counselor');
            $data = $request->validate([
                'name' => 'required',
                'role' => 'required',
                'no_telp' => 'required|unique',
                'email' => 'required',
                'fare' => 'required|numeric'
            ]);
            $data['nip'] = generateNIP();
            $data['rating'] = 0;
        }
        // dd($data);
        $newUser = User::create($data);
        return redirect((route(('user.index'))))->with('success', 'New User Added Successfully !');
    }


    public function edit(User $user){
        $programs = program::all();
        return view('users.edit', ['user' =>$user], ['programs' => $programs]);
    }

    public function update(User $user, Request $request){
        $data = $request->validate([
            'name' => 'required',
            'role' => 'required',
            'no_telp' => 'required|unique',
            'email' => 'required',
        ]);
    
        if ($request['role'] == 'student') {
            if ($user['role'] != $request['role']) {
                $user['nip'] = null;
                $user['fare'] = null;
                $user['rating'] = null;
            }
            $data['program_id'] = $request->input('program_id');
            $data['nip'] = $request->input('nip');
        } elseif ($request['role'] == 'pic') {
            if ($user['role'] != $request['role']) {
                $user['program_id'] = null;
                $user['fare'] = null;
                $user['rating'] = null;
            }
            $data['nip'] = $request->input('nip');
        } elseif ($request['role'] == 'counselor') {
            if ($user['role'] != $request['role']) {
                $user['program_id'] = null;
                $user['nip'] = null;
            }
            $data['fare'] = $request->input('fare');
            $data['rating'] = 0;
        }
    
        $user->update($data);
        return redirect(route('user.index'))->with('success', 'User Updated Successfully');
    }

    public function updateProfile(Request $request){
        $data = $request->validate([
            'user_id' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $user = DB::table('users')
                ->where('users.id', $data['user_id'])
                ->first();

        $user->update($data);
        return redirect(route('user.index'))->with('success', 'User Updated Successfully');
    }

    public function destroy(User $user){
        $user->delete();
        return redirect(route('user.index'))->with('success', 'User Deleted Successfully');
    }
}
