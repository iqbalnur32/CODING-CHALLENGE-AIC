<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function logout()
    {
        \Session::flush();
        return redirect('/login');
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        if(Auth::guard('users')->attempt(['username' => $username, 'password' => $password])) {
            // return redirect('/form');
            // dd(Auth::guard('users')->check());
            $response = array(
                'code'   => 200,
                'status' => 'success',
                'message' => 'Login Success',
                'data' => Auth::guard('web')->user()
            );

            \Session::put('user', Auth::guard('users')->user());
            
            return response()->json($response);
        } else {
            $response = array(
                'code'   => 400,
                'status' => 'failed',
                'message' => 'Login Failed',
                'data' => []
            );
            return response()->json($response);
        }
    }
}
