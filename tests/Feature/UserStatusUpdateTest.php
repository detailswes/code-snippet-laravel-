<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserStatusUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'Admin', 'slug' => 'admin']);
        Role::create(['name' => 'User', 'slug' => 'user']);

        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('StrongPass1!'),
            'role_id' => 1,
            'status' => User::STATUS_ENABLED,
        ]);

        UserRole::create([
            'user_id' => $admin->id,
            'role_id' => 1,
        ]);
    }

    public function test_authenticated_user_can_update_user_status(): void
    {
        $targetUser = User::create([
            'first_name' => 'Target',
            'last_name' => 'User',
            'email' => 'target@example.com',
            'password' => Hash::make('StrongPass1!'),
            'role_id' => 2,
            'status' => User::STATUS_ENABLED,
        ]);

        $this->withoutMiddleware();
        $this->actingAs(User::where('email', 'admin@example.com')->first());

        $response = $this->postJson('/admin/update/user/status', [
            'id' => $targetUser->id,
            'status' => User::STATUS_DISABLED,
        ]);

        $response->assertOk();
        $response->assertJson(['success' => true]);
        $this->assertSame(User::STATUS_DISABLED, $targetUser->fresh()->status);
    }
}
