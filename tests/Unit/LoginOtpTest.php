<?php

namespace Tests\Unit;

use App\Models\LoginOtp;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginOtpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'Admin', 'slug' => 'admin']);
        Role::create(['name' => 'User', 'slug' => 'user']);
    }

    public function test_otp_is_hashed_at_rest(): void
    {
        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'otp@example.com',
            'password' => Hash::make('StrongPass1!'),
            'role_id' => 2,
            'status' => User::STATUS_ENABLED,
        ]);

        LoginOtp::storeForUser($user->id, '123456');

        $storedOtp = LoginOtp::where('user_id', $user->id)->first();

        $this->assertNotSame('123456', $storedOtp->code);
        $this->assertTrue(LoginOtp::verifyForUser($user->id, '123456'));
        $this->assertFalse(LoginOtp::verifyForUser($user->id, '654321'));
    }
}
