<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\program;
use App\Models\status;
use Carbon\Carbon;

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
                return response()->json(['message' => 'User tidak ditemukan', 302]);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Internal server error', 500]);

        }
    }

    public function index(){
        $users = User::all();
        return view('users.index', ['users' => $users]);
        
    }

    public function create(){
        $today = Carbon::now()->toDateString();

        $programs = Program::where('end_date', '>=', $today)->get();
        return view('users.create', ['programs' => $programs]);
    }   

    public function store(Request $request){
        if ($request['role'] == 'student') {
            // dd('User is Student');
            $data = $request->validate([
                'name' => 'required',
                'role' => 'required',
                'no_telp' => 'required|unique:users,no_telp',
                'email' => 'required',
                'program_id' => 'required',
                'nip' => 'required|numeric',
            ]);
        } else if ($request['role'] == 'pic') {
            // dd('User is PIC');
            $data = $request->validate([
                'name' => 'required',
                'role' => 'required',
                'no_telp' => 'required|unique:users,no_telp',
                'email' => 'required',
                'nip' => 'required|numeric',
            ]);
        } else {
            // dd('User is Counselor');
            $data = $request->validate([
                'name' => 'required',
                'role' => 'required',
                'no_telp' => 'required|unique:users,no_telp',
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
            'no_telp' => 'required',
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

    private function uploadedfile0($img, $path) {
        $time=time();
        $newurl=[];
        // dd($img);
        $imag=$img;
        if ($imag->isValid()) {
            $imag->move($path, $time . '_' . $imag->getClientOriginalName());
            $newurl[] = $path . '/' . $time . '_' . $imag->getClientOriginalName();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload file',
                'error' => 'File upload failed',
            ]);
        }
        // dd($newurl);
        return $newurl;
    }

    public function updateProfile(Request $request){
        try {
            $data = $request->validate([
                'user_id' => 'required',
                'email' => 'required',
                'profile_pic' => 'required',
                'password' => 'required',
            ]);

            $files = $request->file('profile_pic');
            $path = 'photo_profile/' . $data['user_id'];
            $paths = $this->uploadedFile0($files, $path);

            $evidencePath = json_encode($paths);
            $user = DB::table('users')
                    ->where('users.id', $data['user_id']);
            
            unset($data['user_id']);
            $data['profile_pic']= $paths;
            // // dd($data);
            $data['password'] = Hash::make($data['password']);
            $user->update($data);
            // dd($up);
                    
            // dd($user, $data);
            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'Update profile successfully',
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
            ]);
        }
    }

    public function checkPass(Request $request){
        try {
            $data = $request->validate([
                'password'=> 'required',
                'pass' => 'required',
            ]);

            if (Hash::check($data['password'], $data['pass'])) {
                return response()->json(['message' => 'Password Correct', 200]);
            } else {
                return response()->json(['message' => 'Password Incorrect', 302]);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Internal server error', 500, json_encode($th)]);
        }
    }

    public function destroy(User $user){
        $user->delete();
        return redirect(route('user.index'))->with('success', 'User Deleted Successfully');
    }

    // public function drivepoin(Request $request){
    //     return view('users.show', ['user' => $user]);
    // }
}
