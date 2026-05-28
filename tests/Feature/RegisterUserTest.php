<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'Admin', 'slug' => 'admin']);
        Role::create(['name' => 'User', 'slug' => 'user']);

        User::create([
            'first_name' => 'Existing',
            'last_name' => 'User',
            'email' => 'existing@example.com',
            'password' => Hash::make('ExistingPass1!'),
            'role_id' => 1,
            'status' => User::STATUS_ENABLED,
        ]);
    }

    public function test_registration_creates_a_new_user(): void
    {
        $response = $this->postJson('/register', [
            'first_name' => 'New',
            'last_name' => 'User',
            'email' => 'newuser@example.com',
            'phone' => '1234567890',
            'password' => 'StrongPass1!',
            'password_confirmation' => 'StrongPass1!',
        ]);

        $response->assertOk();
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'phone' => '1234567890',
        ]);
    }

    public function test_registration_cannot_overwrite_existing_user_by_id(): void
    {
        $existingUser = User::where('email', 'existing@example.com')->first();

        $response = $this->postJson('/register', [
            'id' => $existingUser->id,
            'first_name' => 'Attacker',
            'last_name' => 'User',
            'email' => 'attacker@example.com',
            'phone' => '1234567890',
            'password' => 'StrongPass1!',
            'password_confirmation' => 'StrongPass1!',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['id']);

        $existingUser->refresh();
        $this->assertSame('existing@example.com', $existingUser->email);
        $this->assertSame('Existing', $existingUser->first_name);
        $this->assertDatabaseMissing('users', ['email' => 'attacker@example.com']);
    }
}
