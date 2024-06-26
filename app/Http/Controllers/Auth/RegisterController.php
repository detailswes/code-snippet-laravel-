<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Services\Auth\RegisterUserService;

class RegisterController extends Controller
{

    public function __construct(RegisterUserService $registerUserService)
    {
        $this->registerUserService = $registerUserService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerUser(RegisterUserRequest $request)
    {
        $response = $this->registerUserService->save($request);

        if ($response) {
            $flashMessageText = 'Account created Successfully.';
            session()->flash('success', 'Account created Successfully please login.');
            return response()->json([
                'success' => true,
                'message' => $flashMessageText,
            ]);
        }
        return response()->json(['error' => 'Something went wrong'], 500);
    }
}
