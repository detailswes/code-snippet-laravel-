<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            'Admin',
            'User',
        ];

        foreach ($roles as $key => $role) {
            Role::updateOrCreate([
                'name' => $role,
                'slug' => slugify($role)
            ]);
        }
    }
}
