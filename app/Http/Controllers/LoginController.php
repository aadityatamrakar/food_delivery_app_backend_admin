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
        if($otp != $request->otp){
            return redirect()->route('first')->with(['info'=>"Invalid OTP.", "type"=>"danger"]);
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
            $mobile = urlencode($user->mobile);
            $otp = rand(10000000, 99999999);
            Session::put('otp', $otp);
            session('otp', $otp);
            $message = urlencode("OTP FOR LOGIN ".$otp.'. TromBoy');
            //$res = file_get_contents("http://sms.hostingfever.in/sendSMS?username=spantech&message=$message&sendername=ONLINE&smstype=TRANS&numbers=$mobile&apikey=4d360261-78da-4d98-826c-d02a6771545c");
            return ['status'=>'sent'];
        }else
            return ['status'=>'error', 'error'=>"user_pass_fail"];

    }
}
