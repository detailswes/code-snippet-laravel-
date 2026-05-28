<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class LoginOtp extends Model
{
    protected $fillable = [
        'user_id',
        'code',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function storeForUser(int $userId, string $plainCode): self
    {
        return self::updateOrCreate(
            ['user_id' => $userId],
            ['code' => Hash::make($plainCode)]
        );
    }

    public static function verifyForUser(int $userId, string $plainCode): bool
    {
        $otp = self::where('user_id', $userId)->first();

        if (!$otp) {
            return false;
        }

        return Hash::check($plainCode, $otp->code);
    }
}
