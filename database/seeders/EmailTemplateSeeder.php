<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_templates')->truncate();
        $path = base_path() . '/database/seeders/dump/ForgotPasswordEmailTemplate.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
