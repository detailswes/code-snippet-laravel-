<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRoleId = Role::where('slug', 'admin')->first()->id;
        $adminPassword = env('ADMIN_PASSWORD', 'ChangeMe123!');

        $adminUsers = [
            [
                'email' => env('ADMIN_EMAIL', 'admin@admin.com'),
                'first_name' => 'Super',
                'last_name' => 'Admin'
            ]
        ];

        foreach ($adminUsers as $adminUser) {
            User::updateOrCreate([
                'email' => $adminUser['email']
            ], [
                'first_name' => $adminUser['first_name'],
                'last_name' => $adminUser['last_name'],
                'role_id' => $adminRoleId,
                'password' => Hash::make($adminPassword),
                'email_verified_at' => now(),
                'status' => User::STATUS_ENABLED,
            ]);
        }
    }
}
