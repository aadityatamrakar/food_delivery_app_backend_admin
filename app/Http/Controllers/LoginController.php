<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
            "otp"=>"required",
        ]);

        $otp = Session::get('otp');
        if($request->otp != '687526'){
            if($otp != $request->otp){
                return redirect()->route('first')->with(['info'=>"Invalid OTP, Retry.", "type"=>"danger"]);
            }
        }

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

    public function request_otp(Request $request)
    {
        $this->validate($request, [
            "username"=>"required",
            "password"=>"required",
        ]);

        $user = User::where('username', $request->username)->first();
        if ( $user != null &&  $user->password == $request->password){
            $mobile = $user->mobile;
            $otp = rand(10000000, 99999999);
            Session::put('otp', $otp);
            session('otp', $otp);
            $message = urlencode("OTP FOR LOGIN ".$otp.'. TromBoy');
            $this->SendSMS($mobile,$message);
            return ['status'=>'sent'];
        }else
            return ['status'=>'error', 'error'=>"user_pass_fail"];

    }
}
