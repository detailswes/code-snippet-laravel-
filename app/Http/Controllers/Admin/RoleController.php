<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;
use App\Http\Requests\Admin\CreateRoleRequest;
use App\Services\Admin\RoleService;
use InvalidArgumentException;

class RoleController extends Controller
{
    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        if (Auth::user()->can('roles_listing')) {
            $roles = Role::all();

            return view('admin.roles.index', ['roles' => $roles]);
        }

        abort(403, 'You are not authorized.');
    }

    public function store(CreateRoleRequest $request)
    {
        $this->roleService->save($request);
        $resAction = $request->id ? 'Updated' : 'Stored';
        $flashMessageText = "Role and Permissions $resAction Successfully";

        return response()->json(['status' => true, 'message' => $flashMessageText]);
    }

    public function destroy($id)
    {
        if (Auth::user()->can('roles_delete')) {
            $checkUserRole = UserRole::where('role_id', $id)->first();
            if ($checkUserRole) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'This role is assign to someone user. You can not delete this role.'
                ], 422);
            }

            $deleteRole = $this->roleService->delete($id);

            return response()->json([
                'success' => $deleteRole['status'],
                'message' => $deleteRole['message'],
            ]);
        }

        abort(403, 'You are not authorized.');
    }

    public function openModal(Request $request)
    {
        $request->validate(['view' => 'required|string']);

        try {
            return response()->json([
                'success' => true,
                'html' => $this->roleService->renderModalHTML($request)
            ]);
        } catch (InvalidArgumentException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }
    }
}
