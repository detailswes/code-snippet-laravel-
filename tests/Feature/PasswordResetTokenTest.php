<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordResetTokenTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'Admin', 'slug' => 'admin']);
        Role::create(['name' => 'User', 'slug' => 'user']);
    }

    public function test_expired_password_reset_token_is_rejected(): void
    {
        $token = 'valid-reset-token-that-is-long-enough-for-prefix-lookup';
        $email = 'user@example.com';

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => Hash::make($token),
            'token_prefix' => substr($token, 0, 8),
            'created_at' => now()->subHours(2),
        ]);

        $response = $this->post('/admin/update-password', [
            'token' => $token,
            'new_password' => 'StrongPass1!',
            'password_confirmation' => 'StrongPass1!',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHas('error', 'Invalid or expired token');
    }

    public function test_valid_password_reset_token_updates_password(): void
    {
        $token = 'valid-reset-token-that-is-long-enough-for-prefix-lookup';
        $email = 'user@example.com';

        User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => $email,
            'password' => Hash::make('OldPass1!'),
            'role_id' => 2,
            'status' => User::STATUS_ENABLED,
        ]);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => Hash::make($token),
            'token_prefix' => substr($token, 0, 8),
            'created_at' => now(),
        ]);

        $response = $this->post('/admin/update-password', [
            'token' => $token,
            'new_password' => 'StrongPass1!',
            'password_confirmation' => 'StrongPass1!',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHas('success');

        $this->assertTrue(Hash::check('StrongPass1!', User::where('email', $email)->first()->password));
    }
}
