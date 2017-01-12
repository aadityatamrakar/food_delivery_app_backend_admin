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


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"secret=6LdJkxEUAAAAAAWLrt_LBVnx0py_z96GqGAyKgWK&response=".$request->get('g-recaptcha-response'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec ($ch);
        curl_close ($ch);
        dd($response);

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
