<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionList;
use App\Models\Role;

class PermissionListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Permission::get()->pluck('id', 'name')->toArray();
        $dashBoardPermissionId = $roles['Dashboard'];
        $userPermissionId = $roles['User'];
        $rolePermissionId = $roles['Roles'];

        $permissions = [
            [
                'permission_id' => $dashBoardPermissionId,
                'name' => 'Dashboard :Listing',
                'slug' => 'dashboard_listing'
            ],
            [
                'permission_id' => $userPermissionId,
                'name' => 'User:Listing',
                'slug' => 'user_listing'
            ],
            [
                'permission_id' => $userPermissionId,
                'name' => 'User :Create',
                'slug' => 'user_create'
            ],
            [
                'permission_id' => $userPermissionId,
                'name' => 'User : Edit',
                'slug' => 'user_edit'
            ],
            [
                'permission_id' => $userPermissionId,
                'name' => 'User :Delete',
                'slug' => 'user_delete'
            ],
            [
                'permission_id' =>  $rolePermissionId,
                'name' => 'Roles: Listing',
                'slug' => 'roles_listing'
            ],
            [
                'permission_id' => $rolePermissionId,
                'name' => 'Roles:Create',
                'slug' => 'roles_create'
            ],
            [
                'permission_id' => $rolePermissionId,
                'name' => 'Roles:Edit',
                'slug' => 'roles_edit'
            ],
            [
                'permission_id' => $rolePermissionId,
                'name' => 'Roles: Delete',
                'slug' => 'roles_delete'
            ],

        ];

        foreach ($permissions as $key => $permission) {
            PermissionList::updateOrCreate($permission);
        }
    }
}
