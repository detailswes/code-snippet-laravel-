<?php

namespace App\Services\Admin;

use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class RoleService
{
    private const ALLOWED_MODAL_VIEWS = [
        'admin.roles.create-edit-role',
    ];

    public function save(Request $request): ?Role
    {
        return DB::transaction(function () use ($request) {
            $data = Role::updateOrCreate([
                'id' => $request->id,
            ], [
                'name' => $request->name,
                'slug' => slugify($request->name),
            ]);

            if (!$data) {
                return null;
            }

            RolePermission::where('role_id', $data->id)->delete();

            if ($request->permissions !== null) {
                $this->storeRole($request->permissions, $data);
            }

            $this->clearPermissionCache();

            return $data;
        });
    }

    private function storeRole(array $permissionList, Role $data): void
    {
        foreach ($permissionList as $getPermissionListId) {
            RolePermission::updateOrCreate([
                'role_id' => $data->id,
                'permission_id' => $getPermissionListId
            ]);
        }
    }

    public function delete($id): array
    {
        RolePermission::where('role_id', $id)->delete();
        Role::find($id)?->delete();
        $this->clearPermissionCache();

        return [
            'status' => true,
            'message' => 'Role and Permission deleted successfully'
        ];
    }

    public function renderModalHTML(Request $request): string
    {
        $viewName = $this->resolveModalView($request->view);
        $id = $request->id;
        $roles = null;

        if ($id) {
            $roles = Role::with('permissions')->where('id', $id)->first();
            $permissionArray = [];

            if ($roles) {
                foreach ($roles->permissions as $permission) {
                    $permissionArray[] = $permission->permission_id;
                }
                $roles->permissionArray = $permissionArray;
            }
        }

        $permissionListData = Permission::with('lists')->get();

        return view($viewName, [
            'roles' => $roles ?? null,
            'permissionListData' => $permissionListData ?? null,
        ])->render();
    }

    private function resolveModalView(string $view): string
    {
        if (!in_array($view, self::ALLOWED_MODAL_VIEWS, true)) {
            throw new InvalidArgumentException('Invalid modal view requested.');
        }

        return $view;
    }

    private function clearPermissionCache(): void
    {
        Cache::forget('permission_list');
    }
}
