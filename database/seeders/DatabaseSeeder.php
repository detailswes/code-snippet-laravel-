<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(PermissionListSeeder::class);
        $this->call(RolePerimissionSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(EmailTemplateSeeder::class);

        Cache::forget('permission_list');
    }
}
