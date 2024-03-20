<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\program;
use App\Models\rating;
use Carbon\Carbon;
use App\Mail\HeeruMail;
use App\Models\comment;
use App\Models\post;

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
                $userArray = [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'no_telp' => $user->no_telp,
                    'email' => $user->email,
                    'password' => $user->password ? '*******' : '',
                    'profile_pic' => $user->profile_pic ? json_decode($user->profile_pic)[0] : '',
                    'username' => $user->username
                ];
                return response()->json([
                    'success' => true,
                    'message' => 'User found',
                    'user' => $userArray,
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'NIP not found!',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function getUserProfile(Request $request){
        try {
            $user = DB::table('users')
            ->where('users.id', $request->input('user_id'))
            ->first();

            if($user){
                $userArray = [
                    'name' => $user->name,
                    'no_telp' => $user->no_telp,
                    'email' => $user->email,
                    'profile_pic' => $user->profile_pic ? json_decode($user->profile_pic)[0] : '',
                    'username' => '@' . str_replace(' ', '', strtolower($user->username))
                ];
    
                return response()->json([
                    'success' => true,
                    'message' => 'fetch user profile successfully',
                    'user' => $userArray,
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'User not found!',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function index(Request $request){
        $role = $request->input('role');
        if (!$role) {
            $users = User::all();
        } else {
            $users = User::where('role', $role)->get();
        }
        return view('users.index', ['users' => $users, 'role' => $role]);
        
    }

    public function create(Request $request){
        $role = $request->input('role');
        $role = $role ? $role : 'student';
        $today = Carbon::now()->toDateString();
        $programs = Program::where('end_date', '>=', $today)->get();
        return view('users.create', ['programs' => $programs, 'role' => $role]);
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
        return $newurl;
    }

    public function store(Request $request){
        if ($request['role'] == 'student') {
            $data = $request->validate([
                'name' => 'required',
                'role' => 'required',
                'no_telp' => 'required|unique:users,no_telp',
                'email' => 'required',
                'program_id' => 'required',
                'nip' => 'required|numeric',
                'username' => 'required'
            ]);
        } else if ($request['role'] == 'pic' || $request['role'] == 'admin') {
            // dd('User is PIC');
            $data = $request->validate([
                'name' => 'required',
                'role' => 'required',
                'no_telp' => 'required|unique:users,no_telp',
                'email' => 'required',
                'nip' => 'required|numeric',
                'password' => 'required',
            ]);
            $data['password'] = Hash::make($data['password']);

        }else {
            // dd('User is Counselor');
            $data = $request->validate([
                'name' => 'required',
                'role' => 'required',
                'no_telp' => 'required|unique:users,no_telp',
                'email' => 'required',
                'fare' => 'required|numeric',
            ]);
            $data['nip'] = generateNIP();
            $data['rating'] = 0;
        }

        $newUser = User::create($data);

        if ($request['role'] == 'pic' || $request['role'] == 'admin' || $request['role'] == 'counselor') {
            $data = $request->validate([
                'profile_pic' => 'required',
            ]);
            // dd($request->file('profile_pic'));
            $files = $request->file('profile_pic');
            $path = 'photo_profile/' . $newUser['id'];
            $paths = $this->uploadedFile0($files, $path);
            
            $data['profile_pic']= $paths;
            $newUser->update($data);
        }
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
        } elseif ($request['role'] == 'pic' || $request['role'] == 'admin') {
            if ($user['role'] != $request['role']) {
                $user['program_id'] = null;
                $user['fare'] = null;
                $user['rating'] = null;
            }
            $data['password'] = Hash::make($request->input('password'));
        } elseif ($request['role'] == 'counselor') {
            if ($user['role'] != $request['role']) {
                $user['program_id'] = null;
                $user['nip'] = null;
            }
            $data['fare'] = $request->input('fare');
        }

        if ($request['role'] == 'counselor' || $request['role'] == 'admin' || $request['role'] == 'pic'){
            if($request->hasfile('profile_pic')){
                $profilePicFolderPath = public_path('photo_profile/' .  $user['id']);
                if (File::exists($profilePicFolderPath)) {
                    File::deleteDirectory($profilePicFolderPath);
                }
                $files = $request->file('profile_pic');
                $path = 'photo_profile/' . $user['id'];
                $paths = $this->uploadedFile0($files, $path);
                $data['profile_pic'] = $paths;
            }
        }
        // dd($data);
        $user->update($data);
        return redirect(route('user.index'))->with('success', 'User Updated Successfully');
    }

    public function updateProfile(Request $request){
        try {
            $data = $request->validate([
                'user_id' => 'required',
                'username' => 'required',
                'email' => 'required',
                'profile_pic' => 'required',
                'password' => 'required',
            ]);

            $files = $request->file('profile_pic');
            $path = 'photo_profile/' . $data['user_id'];
            $paths = $this->uploadedFile0($files, $path);

            $user = DB::table('users')
                    ->where('users.id', $data['user_id']);
            
            unset($data['user_id']);
            $data['profile_pic']= $paths;
            $data['password'] = Hash::make($data['password']);
            $user->update($data);
                    
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

    public function updatePP(Request $request){
        $data = $request->validate([
            'profile_pic' => 'required',
        ]);

        $user = User::where('id', Auth::user()->id)->first();

        $profilePicFolderPath = public_path('photo_profile/' .  $user['id']);
        if (File::exists($profilePicFolderPath)) {
            File::deleteDirectory($profilePicFolderPath);
        }

        $files = $request->file('profile_pic');
        $path = 'photo_profile/' . $user->id;
        $paths = $this->uploadedFile0($files, $path);

        $data['profile_pic']= $paths;
        $user->update($data);
        return redirect(route('profile'))->with('success', 'Profile Image Updated Successfully');
    }

    public function changePass(Request $request){
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);
        $user = User::where('id', Auth::user()->id)->first();
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect(route('profile'))->with('success', 'Password changed successfully.');
    }

    public function changePhone(Request $request){
        $request->validate([
            'new_phone' => 'required',
        ]);
        $user = User::where('id', Auth::user()->id)->first();
        $user->no_telp = $request->new_phone;
        $user->save();
        return redirect(route('profile'))->with('success', 'Phone number updated successfully.');
    }

    public function changeEmail(Request $request)
    {
        $request->validate([
            'new_email' => 'required',
        ]);
        $user = User::where('id', Auth::user()->id)->first();
        $user->email = $request->new_email;
        $user->save();
        return redirect(route('profile'))->with('success', 'Email updated successfully.');
    }

    public function checkPass(Request $request){
        try {
            $data = $request->validate([
                'password'=> 'required',
                'user_id' => 'required',
            ]);

            $pass = User::where( 'id',$data['user_id'])->value( 'password');

            if (Hash::check($data['password'], $pass)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Password Correct',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Password Incorrect',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
            ]);
        }
    }

    public function destroy(User $user){
        $user->delete();
        return redirect(route('user.index'))->with('success', 'User Deleted Successfully');
    }

    public function showCounselor(){
        $counselors = User::where('role', 'counselor')->get();

        if ($counselors->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'There are no counselors registered',
            ]);
        }

        $dataCounselors = [];

        foreach ($counselors as $counselor) {
            $ratings = rating::where('ratings.counselor_id', '=', $counselor->id)->get();
            // dd($ratings);
            $totalRating = 0;
            $numberOfRatings = $ratings->count();
            foreach ($ratings as $rating) {
                $totalRating += $rating->rating;
            }
            // dd($numberOfRatings);
            if ($numberOfRatings > 0) {
                $averageRating = $totalRating / $numberOfRatings;
            } else {
                $averageRating = 5;
            }

            $dataCounselors[] = [
                'user_id' => $counselor->id,
                'name' => $counselor->name,
                'fare' => $counselor->fare,
                'rating' => $averageRating,
                'profile_pic' => json_decode($counselor->profile_pic),
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Fetched all counselors',
            'users' => $dataCounselors,
        ]);
    }

    public function showCons(Request $request){
        try {
            $data = $request->validate([
                'user_id' => 'required',
            ]);

            $user = User::where( 'id', $data['user_id'])->first();

            $ratings = rating::where('counselor_id', $data['user_id'])->get();
            $totalRating = 0;
            $numberOfRatings = $ratings->count();
            foreach ($ratings as $rating) {
                $totalRating += $rating->rating;
            }
            if ($numberOfRatings > 0) {
                $averageRating = $totalRating / $numberOfRatings;
            } else {
                $averageRating = 5;
            }
            $showCounselorData = [
                'user_id' => $user->id,
                'name' => $user->name,
                'rating' => $averageRating,
                'fare' => $user->fare,
                'description' => $user->description,
                'profile_pic' => json_decode($user->profile_pic)[0],
            ];

            return response()->json([
                'success' => true,
                'message' => 'Fetched counselor data',
                'users' => $showCounselorData,
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
            ]);
        }
    }

    public function getProfile(){
        $user = User::where('id', Auth::user()->id)->first();
        $userArray = [
            'user_id' => $user->id,
            'name' => $user->name,
            'role' => $user-> role,
            'no_telp' => $user->no_telp,
            'email' => $user->email,
            'profile_pic' => $user->profile_pic ? json_decode($user->profile_pic)[0] : '',
        ];
        return view('profile.index', ['user' => $userArray]);
    }

    public function getPP(Request $request){
        try {
            $user = User::where('id', $request->input('user_id'))->first();
            $userArray = [
                'profile_pic' => $user->profile_pic ? json_decode($user->profile_pic)[0] : '',
            ];
            return response()->json([
                'success' => true,
                'message' => 'get user photo profile successfully',
                'pp' => $userArray,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function changePasss(Request $request){
        $data  = $request->validate([
            'user_id' => 'required',
            'email' => 'required',
            'old_password' => 'required'
        ]);
        $user = User::where('id', $data['user_id'])->first();
        if($user){
            if($data['email'] == $user->email){
                if(Hash::check($data['old_password'], $user->password)){
                    return response()->json([
                        'success' => true,
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Wrong Password!',
                    ]);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'The email you entered is not registered!',
                ]);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User not found!',
            ]);
        }
    }

    public function changePassword(Request $request){
        $data  = $request->validate([
            'user_id' => 'required',
            'new_password' => 'required'
        ]);
        $user = User::where('id', $data['user_id'])->first();
        $user->password = Hash::make($data['new_password']);
        $Update = $user->save();
        return response()->json([
            'success' => true,
        ]);
    }

    public function checkUsername(Request $request){
        $username = $request->input('username');

        $isUsernameTaken = User::where('username', $username)->exists();
        if ($isUsernameTaken) {
            return response()->json(['success' => false, 'message' => 'Username is taken']);
        } else {
            return response()->json(['success' => true, 'message' => 'Username is available']);
        }
    }

    public function tag(Request $request){
        $comment_id = $request->input('comment_id');
        $user_id = comment::where('comments.id', $comment_id)->value('user_id');
        $username = User::where('users.id', $user_id)->value('username');
        // dd($username);
        if ($username) {
            return response()->json(['success' => true, 'message' => 'Successfully Tagged', 'tag'=>'@' . str_replace(' ', '', strtolower($username))]);
        } else {
            return response()->json(['success' => false, 'message' => 'Tag Failed' ]);
        }
    }

    public function otp(Request $req){
        // return view('Mail.mainotp', ['otp' => '123456']);
        try {
            $target = $req->input('email');
            $otp = rand(100000, 999999);
            $dw=Mail::to($target)->send(new HeeruMail($otp));
            return response()->json([
                'success' => true,
                'message' => 'OTP Mail Send Successfully',
                $dw,'otp' => $otp
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => $th->getMessage(),
            ]);
        }
    }
}
