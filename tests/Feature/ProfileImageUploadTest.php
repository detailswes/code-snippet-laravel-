<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileImageUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'Admin', 'slug' => 'admin']);
        Role::create(['name' => 'User', 'slug' => 'user']);

        $this->actingAs(User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('StrongPass1!'),
            'role_id' => 1,
            'status' => User::STATUS_ENABLED,
        ]));
    }

    public function test_profile_image_upload_rejects_php_extension(): void
    {
        $payload = 'data:image/php;base64,' . base64_encode('<?php echo "x"; ?>');

        $response = $this->postJson('/admin/account/update/profile/image', [
            'image' => $payload,
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
        ]);
    }
}
