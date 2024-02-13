<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // dd($data);
        $role = User::where('nip', $data['nip'])->value('role');

        if (!in_array($role, ['admin', 'pic'])) {
            return redirect("/")->with('error','Student cannot  access this page!');
        }

        if (Auth::Attempt($data)) {
            return redirect('dashboard');
        }else{
            return redirect("/")->with('error','NIP or Password Incorrect!');
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
