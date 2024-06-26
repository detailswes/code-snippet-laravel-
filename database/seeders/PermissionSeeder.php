<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'Dashboard',
            ],
            [
                'name' => 'User',
            ],
            [
                'name' => 'Roles',
            ],
        ];

        foreach ($permissions as $key => $permission) {
            Permission::updateOrCreate($permission);
        }
    }
}
