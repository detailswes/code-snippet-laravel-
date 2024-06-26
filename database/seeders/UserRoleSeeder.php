<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::select('id', 'role_id')->where('email', 'admin@admin.com')->first();
        if ($user) {
            UserRole::updateOrCreate([
                'user_id' => $user->id,
                'role_id' => $user->role_id
            ]);
        }
    }
}
