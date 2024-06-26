<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Role;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class RegisterUserService
{

    public function save(Request $request)
    {
        $requestData = [
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'role_id' => Role::where('slug', 'user')->first()->id,
            'password' =>  bcrypt($request->password),
            'status' => 1,
        ];

        DB::beginTransaction();

        try {
            User::updateOrCreate([
                'id' => $request->id,
            ], $requestData);
            DB::connection()->commit();
            return true;
        } catch (\Exception $e) {
            DB::connection()->rollBack();
            Log::info('Register Excecption' . $e->getMessage());
        }
    }
}
