<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Services\Admin\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'Admin', 'slug' => 'admin']);
        Role::create(['name' => 'User', 'slug' => 'user']);

        $this->userService = app(UserService::class);
    }

    public function test_delete_removes_user_role_by_user_id(): void
    {
        $user = User::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('StrongPass1!'),
            'role_id' => 2,
            'status' => User::STATUS_ENABLED,
        ]);

        UserRole::create([
            'user_id' => $user->id,
            'role_id' => 2,
        ]);

        $this->userService->delete($user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('user_roles', ['user_id' => $user->id]);
    }

    public function test_render_modal_html_rejects_unknown_view(): void
    {
        $request = Request::create('/admin/open/user/modal', 'POST', [
            'view' => 'admin.dashboard',
            'id' => null,
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->userService->renderModalHTML($request);
    }
}
