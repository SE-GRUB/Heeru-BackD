<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// use Session;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }else{
            return view('login.index');
        }
    }

    public function actionlogin(Request $request){
        $data = [
            'nip' => $request->input('nip'),
            'password' => $request->input('password'),
        ];
        $role = User::where('nip', $data['nip'])->value('role');
        // dd($role);

        if (in_array($role, ['admin', 'pic'])) {
            // dd(Auth::Attempt($data));
            if (Auth::Attempt($data)) {
                return redirect('dashboard');
            }else{
                return redirect("/")->with('error','NIP or Password Incorrect!');
            }
        }else{
            return redirect("/")->with('error','Student cannot  access this page!');
        }
    }

    public function reset_phone(Request $request){
        $data  = $request->validate([
            'phone_nip' => 'required',
            'phone_number'=> 'required',
            'new_password' => 'required'
        ]);
        // dd($data);
        $user = User::where('nip', $data['phone_nip'])->first();
        // dd($user);

        if($user){
            if(in_array($user->role, ['admin', 'pic'])){
                if($data['phone_number'] === $user->no_telp){
                    $user->password = Hash::make($data['new_password']);
                    $Update = $user->save();
                    return redirect("/")->with('success','Reset Password Success! Please Login with your new password');
                }else{
                    return redirect("/")->with('error','Reset Password Failed. Phone Number is not match with your account!');
                }
            }else{
                return redirect("/")->with('error','Reset Password Failed. Student cannot  access this page!');
            }
        }else{
            return redirect("/")->with('error','Reset Password Failed. User  not found!');
        }
    }

    public function reset_email(Request $request){
        $data  = $request->validate([
            'email_nip' => 'required',
            'email_reset'=> 'required',
            'new_password_email' => 'required'
        ]);
        // dd($data);
        $user = User::where('nip', $data['email_nip'])->first();
        // dd($user);

        if($user){
            if(in_array($user->role, ['admin', 'pic'])){
                if($data['email_reset'] === $user->email){
                    $user->password = Hash::make($data['new_password_email']);
                    $Update = $user->save();
                    return redirect("/")->with('success','Reset Password Success! Please Login with your new password');
                }else{
                    return redirect("/")->with('error','Reset Password Failed.  The email you entered is not registered in our system!');
                }
            }else{
                return redirect("/")->with('error','Reset Password Failed. Student cannot  access this page!');
            }
        }else{
            return redirect("/")->with('error','Reset Password Failed. User  not found!');
        }
    }

    public function dashboard(){
        return view('backend.index');
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
