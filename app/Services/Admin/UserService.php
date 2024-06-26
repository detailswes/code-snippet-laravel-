<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Role;

use App\Models\UserRole;


class UserService
{

    public function save(Request $request)
    {
        $requestData = [
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'role_id' => $request->role_id,
        ];

        /* In case of editing the users the request has not passwords */
        if ($request->password) {
            $requestData['password'] =  bcrypt($request->password);
        }

        $data = User::updateOrCreate([
            'id' => $request->id
        ], $requestData);

        if ($data) {
            /* If the users has already any role then update it else insert a new rows */
            UserRole::updateOrCreate([
                'user_id' => $data->id
            ], [
                'role_id' => $request->role_id
            ]);
        }
    }

    public function delete($id)
    {
        UserRole::find($id)->delete();
        return User::find($id)->delete();
    }

    public function updateStatus(Request $request)
    {
        return User::findOrFail($request->id)->update([
            'status' => $request->status
        ]);
    }

    public function renderModalHTML(Request $request)
    {
        $user = User::find($request->id);

        /* For adding Next and previous buttons on the view modal */
        if ($user) {
            $user->nextAndPrevious();
        }

        return view($request->view, [
            'roles' => Role::all(),
            'user' => $user ?? null,
        ])->render();
    }
}
