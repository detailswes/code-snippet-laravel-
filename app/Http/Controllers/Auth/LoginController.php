<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /* Show Login Form */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /*  For Submitting the Login Form */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $dataArr['status'] = 'success';
            return response()->json($dataArr);
        }
        return response()->json(['status' => 'fail', 'message' => 'Please fill correct credentials.'], 403);
    }
    /* Logout Function */
    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        return redirect('/admin');
    }
}
