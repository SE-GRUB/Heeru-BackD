<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function logins(){
        return view('login.index');
    }

    public function dashboard(){
        if(Auth::check())
        {
            return view('auth.dashboard');
        }
        
        return redirect()->route('login');
    }

    public function process_login(Request $request){
        $credentials = $request->validate([
            'nip' => 'required',
            'password' => 'required'
        ]);
        
        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
        }

        // return back()->withErrors([
        //     'email' => 'Your provided credentials do not match in our records.',
        // ])->onlyInput('email');
        return back()->with('error', 'Login Failed, Please Check Email or Password');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
