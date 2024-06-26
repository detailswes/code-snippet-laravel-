<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionList;
use App\Models\Role;
use App\Models\RolePermission;

class RolePerimissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = Role::all();
        foreach ($roles as  $role) {
            if ($role->slug == 'admin') {
                $permissions = PermissionList::get()->pluck('id', 'name')->toArray();
            } elseif ($role->slug == 'user') {
                $slugs = ['dashboard_listing', 'user_listing',];
                $permissions = PermissionList::whereIn('slug', $slugs)->get()->pluck('id', 'name')->toArray();
            }
            foreach ($permissions as $permission) {
                RolePermission::updateOrCreate([
                    'role_id' => $role->id,
                    'permission_id' => $permission
                ]);
            }
        }
    }
}
