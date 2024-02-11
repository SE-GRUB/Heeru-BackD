<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function actionlogin(Request $request)
    {
        $data = [
            'nip' => $request->input('nip'),
            'password' => $request->input('password'),
        ];

        if (Auth::Attempt($data)) {
            return redirect('dashboard');
        }else{
            // Session::flash('error', 'Email atau Password Salah');
            return redirect('/');
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
