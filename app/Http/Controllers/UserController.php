<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\student;
use App\Models\pic;
use App\Models\counselor;


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

    public function index(){
        $users = User::all();
        return view('users.index', ['users' => $users]);
        
    }

    public function create(){
        return view('users.create');
    }

    public function store(Request $request){
        // dd($data['role']);
        // $newUser = User::create($data);
        $data = $request->validate([
            'name' => 'required',
            'role' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
        ]);

        $newUser = User::create($data);
        $userId = $newUser->id;

        if ($request['role'] == 'student') {
            // dd('User is Student');
            $studentData = $request->validate([
                'program_id' => 'required',
                'nip' => 'required|numeric',
            ]);
            $studentData['user_id'] = $userId;
            $newStudent = Student::create($studentData);
        } else if ($request['role'] == 'pic') {
            // dd('User is PIC');
            $picData = $request->validate([
                'nip' => 'required|numeric',
            ]);
            $picData['user_id'] = $userId;
            $newPIC = pic::create($picData);
        } else {
            // dd('User is Counselor');
            $counselorData = $request->validate([
                'fare' => 'required|decimal:2'
            ]);
            $counselorData['user_id'] = $userId;
            $counselorData['rating'] = 0;
            $newCounselor = counselor::create($counselorData);
        }

        return redirect((route(('user.index'))));
    }


    public function edit(User $user){
        return view('user.edit', ['user' =>$user]);
    }

    public function update(User $user, Request $request){
        $data = $request->validate([
            'name' => 'required',
            'nip' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
            'remember_token' => 'nullable'
        ]);

        $user->update(($data));
        return redirect(route('user.index'))->with('sucess', 'User Updated Successfully');
    }

    public function destroy(User $user){
        $user->delete();
        return redirect(route('user.index'))->with('success', 'User Deleted Successfully');
    }
}
