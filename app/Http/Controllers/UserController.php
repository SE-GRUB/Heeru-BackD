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
        $roles = [];

        foreach ($users as $user) {
            // Fetch roles for the current user
            $userRoles = DB::table('users')
                ->leftJoin('students', 'students.user_id', '=', 'users.id')
                ->leftJoin('pics', 'pics.user_id', '=', 'users.id')
                ->where('users.id', $user->id)
                ->select(DB::raw('IF(students.id IS NOT NULL, "student", IF(pics.id IS NOT NULL, "pic", NULL)) AS role'))
                ->get();

            // Push the roles for the current user to the roles array
            $roles[$user->id] = $userRoles;
        }

        $usersAndRoles = $users->map(function($user) use ($roles) {
            $userRoles = isset($roles[$user->id]) ? $roles[$user->id] : [];
            return (object) [
                'user' => $user,
                'roles' => $userRoles,
            ];
        });
        return view('users.index', ['usersAndRoles' => $usersAndRoles]);
        
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
        return view('users.edit', ['user' =>$user]);
    }

    public function update(User $user, Request $request){
    // dd($data['role']);
        // $newUser = User::create($data);
        $data = $request->validate([
            'name' => 'required',
            'role' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
        ]);

        if ($request['role'] == 'student') {
            // dd('User is Student');
            $studentData = $request->validate([
                'program_id' => 'required',
                'nip' => 'required|numeric',
            ]);
            $user->update(($studentData));

        } else if ($request['role'] == 'pic') {
            // dd('User is PIC');
            $picData = $request->validate([
                'nip' => 'required|numeric',
            ]);
            $user->update(($picData));
        } else {
            // dd('User is Counselor');
            $counselorData = $request->validate([
                'fare' => 'required|decimal:2'
            ]);
            $user->update(($counselorData));
        }

        return redirect((route(('users.index'))));
    }

    public function destroy(User $user){
        $user->delete();
        return redirect(route('user.index'))->with('success', 'User Deleted Successfully');
    }
}
