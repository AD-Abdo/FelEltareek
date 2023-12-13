<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function Login()
    {
        if(Auth::check()){
            return redirect()->route('dashboard.home');
        }
        return view('auth.login');
    }

    
    public function SignIn(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        

        $auth = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if(!$auth){
            return redirect()->route('login')->with('error','برجاء التاكد من البريد الالكتروني او كلمة المرور');
        }
        cookie()->queue(cookie()->forever('email', $request->email));
        cookie()->queue(cookie()->forever('password', $request->password));
        return redirect()->route('dashboard.home');
    }

    
}
