<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Services\Auth\RegisterUserService;

class RegisterController extends Controller
{
    private RegisterUserService $registerUserService;

    public function __construct(RegisterUserService $registerUserService)
    {
        $this->registerUserService = $registerUserService;
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

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
