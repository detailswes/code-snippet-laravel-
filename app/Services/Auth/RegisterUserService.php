<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterUserService
{
    public function save(Request $request): bool
    {
        $requestData = [
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'role_id' => Role::where('slug', 'user')->first()->id,
            'password' => Hash::make($request->password),
            'status' => User::STATUS_ENABLED,
        ];

        try {
            DB::transaction(function () use ($requestData) {
                User::create($requestData);
            });

            return true;
        } catch (\Exception $e) {
            Log::info('Register Excecption' . $e->getMessage());
        }

        return false;
    }
}
