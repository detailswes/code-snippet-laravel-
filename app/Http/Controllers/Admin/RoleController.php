<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Http\Requests\Admin\CreateRoleRequest;
use App\Models\UserRole;
use App\Services\Admin\RoleService;
use App\Traits\HasPermissionsTrait;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    use HasPermissionsTrait;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /* Display listing  of roles if user have permission of roles listing */
    public function index()
    {
        if (Auth::user()->can('roles_listing')) {
            $roles = Role::all();
            return view('admin.roles.index', ['roles' => $roles]);
        }
        abort(403, 'You are not authorized.');
    }

    /* Create and Update Roles and Permissions */
    public function store(CreateRoleRequest $request)
    {

        $this->roleService->save($request);
        $resAction = $request->id ? 'Updated' : 'Stored';
        $flashMessageText = "Role and Permissions $resAction Successfully";

        return response()->json(["status" => true, 'message' => $flashMessageText]);
    }

    /* Delete role and its permissions  */
    public function destroy($id)
    {
        if (Auth::user()->can('roles_delete')) {
            $checkUserRole = UserRole::where('role_id', $id)->first();
            if ($checkUserRole) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'This role is assign to someone user. You can not delete this role.'
                ], 401);
            }
            $deleteRole = $this->roleService->delete($id);
            /* Response values below are the values returned from Role Service */
            return response()->json([
                "success" => $deleteRole['status'],
                'message' => $deleteRole['message'],
            ]);
        }
        abort(403, 'You are not authorized.');
    }

    /* Open Create and Edit Model */
    public function openModal(Request $request)
    {
        $request->validate(['view' => 'required']);
        return response()->json([
            'success' => true,
            'html' => $this->roleService->renderModalHTML($request)
        ]);
    }
}
