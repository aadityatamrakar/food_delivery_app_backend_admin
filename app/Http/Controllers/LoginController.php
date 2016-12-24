<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check())
            return redirect()->route('dashboard');
        else
            return view('login');
    }

    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            "username"=>"required",
            "password"=>"required",
        ]);


        $user = User::where('username', $request->username)->first();
        if ( $user != null &&  $user->password == $request->password){
            Auth::login($user);
            return redirect()->route('dashboard');
        }else
            return redirect()->route('first')->with(['info'=>"Login Failed", "type"=>"danger"]);
    }

    public function logout()
    {
        Auth::Logout();

        return redirect()->route('first')->with(['info'=>"Logged out successfully", "type"=>"success"]);
    }
}
