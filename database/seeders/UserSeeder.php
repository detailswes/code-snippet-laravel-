<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRoleId = Role::whereName('admin')->first()->id;

        $adminUsers = [
            [
                'email' => 'admin@admin.com',
                'first_name' => 'Super',
                'last_name' => 'Admin'
            ]
        ];

        $users = [];

        foreach ($adminUsers as $key => $adminUser) {
            User::updateOrCreate([
                'email' => $adminUser['email']
            ], [
                'first_name' => $adminUser['first_name'],
                'last_name' => $adminUser['last_name'],
                'role_id' => $adminRoleId,
                'password' => bcrypt('123456'),
                'role_id' => $adminRoleId,
                'email_verified_at' => now(),
                'status' => 1
            ]);
        }
    }
}
