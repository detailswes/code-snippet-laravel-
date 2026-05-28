<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'Admin', 'slug' => 'admin']);
        Role::create(['name' => 'User', 'slug' => 'user']);

        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('StrongPass1!'),
            'role_id' => 1,
            'status' => User::STATUS_ENABLED,
        ]);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $response = $this->postJson('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'StrongPass1!',
        ]);

        $response->assertOk();
        $response->assertJson(['status' => 'success']);
        $this->assertAuthenticated();
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $response = $this->postJson('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'WrongPass1!',
        ]);

        $response->assertStatus(403);
        $this->assertGuest();
    }
}
