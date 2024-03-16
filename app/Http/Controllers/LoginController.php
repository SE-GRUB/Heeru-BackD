<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Mail\HeeruMail;


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
        Log::info('Memulai fungsi actionlogin');
    
        // dd("MASUK");
        $data = $request->validate([
            'nip' => 'required',
            'password'=> 'required',
        ]);
    
        // Log data yang diterima
        Log::debug('Data yang diterima: ' . json_encode($data));
    
        // Lakukan otentikasi pengguna
        $role = User::where('nip', $data['nip'])->value('role');
        Log::debug('Peran pengguna: ' . $role);
    
        // Log apakah otentikasi berhasil atau tidak
        if (in_array($role, ['admin', 'pic'])) {
            if (Auth::attempt($data)) {
                Log::info('Otentikasi berhasil');
                return redirect('dashboard');
            } else {
                Log::warning('Otentikasi gagal: NIP atau password tidak sesuai');
                return redirect("/")->with('error','NIP or Password Incorrect!');
            }
        } else {
            Log::warning('Otentikasi gagal: Pengguna tidak memiliki peran yang sesuai');
            return redirect("/")->with('error','This page is only for admin and PIC!');
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

    public function actionlogout(){
        Auth::logout();
        return redirect('/');
    }

    public function otp(Request $req)
    {
        $targer = $req->input('target');
        $otp = rand(100000, 999999);
        $dw=Mail::to($targer)->send(new HeeruMail($otp));
        return response()->json([$dw,'otp' => $otp]);
    }
}
