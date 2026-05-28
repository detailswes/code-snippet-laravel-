<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class UserService
{
    private const ALLOWED_MODAL_VIEWS = [
        'admin.users.create',
        'admin.users.view',
    ];

    public function save(Request $request): void
    {
        $requestData = [
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'role_id' => $request->role_id,
        ];

        if ($request->password) {
            $requestData['password'] = Hash::make($request->password);
        }

        DB::transaction(function () use ($request, $requestData) {
            $data = User::updateOrCreate([
                'id' => $request->id
            ], $requestData);

            UserRole::updateOrCreate([
                'user_id' => $data->id
            ], [
                'role_id' => $request->role_id
            ]);
        });
    }

    public function delete($id): bool
    {
        UserRole::where('user_id', $id)->delete();

        return (bool) User::find($id)?->delete();
    }

    public function updateStatus(Request $request): bool
    {
        return (bool) User::findOrFail($request->id)->update([
            'status' => $request->status
        ]);
    }

    public function renderModalHTML(Request $request): string
    {
        $viewName = $this->resolveModalView($request->view);
        $user = User::find($request->id);

        if ($user) {
            $user->nextAndPrevious();
        }

        return view($viewName, [
            'roles' => Role::all(),
            'user' => $user ?? null,
        ])->render();
    }

    private function resolveModalView(string $view): string
    {
        if (!in_array($view, self::ALLOWED_MODAL_VIEWS, true)) {
            throw new InvalidArgumentException('Invalid modal view requested.');
        }

        return $view;
    }
}
