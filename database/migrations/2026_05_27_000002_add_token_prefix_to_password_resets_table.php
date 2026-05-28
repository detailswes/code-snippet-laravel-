<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->string('token_prefix', 8)->nullable()->after('token');
            $table->index('token_prefix');
        });
    }

    public function down(): void
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropIndex(['token_prefix']);
            $table->dropColumn('token_prefix');
        });
    }
};
