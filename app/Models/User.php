<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\NextAndPrevious;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\LoginOtp;
use App\Models\EmailTemplate;
use App\Mail\SendCodeMail;
use App\Traits\HasPermissionsTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Filterable, NextAndPrevious, HasPermissionsTrait;

    public const ROLE_ADMIN_SLUG = 'admin';

    public const STATUS_DISABLED = 0;
    public const STATUS_ENABLED = 1;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'role_id',
        'status',
        'original_path'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['full_name', 'profile_image_path'];

    public function isAdmin(): bool
    {
        return $this->role->slug === self::ROLE_ADMIN_SLUG;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function scopeIsNotSuperAdmin(Builder $query): Builder
    {
        return $query->whereHas('role', function (Builder $roleQuery) {
            $roleQuery->where('slug', '!=', self::ROLE_ADMIN_SLUG);
        });
    }

    protected function fullName(): Attribute
    {
        return new Attribute(
            get: fn () => $this->first_name . ' ' . $this->last_name,
        );
    }

    public function profileImagePath(): Attribute
    {
        return new Attribute(
            get: fn () => optional($this->files()->where('type', 'profile_image')->first())->path,
        );
    }

    public function originalImagePath()
    {
        return optional($this->files()->where('type', 'profile_image')->first())->original_path;
    }

    public function fullProfileImagePath()
    {
        if ($this->profile_image_path) {
            return Storage::url($this->profile_image_path);
        }

        return url('../img/admin.jpeg');
    }

    public function fullOriginalProfileImagePath()
    {
        if ($this->original_path) {
            return Storage::url($this->original_path);
        }

        return url('../img/admin.jpeg');
    }

    public function generateCode(): void
    {
        $code = (string) random_int(100000, 999999);

        LoginOtp::storeForUser(auth()->user()->id, $code);

        try {
            $template = EmailTemplate::where('slug', 'OTP_Template')->first();

            if (!$template) {
                return;
            }

            $body = $template->description;
            $subject = $template->subject;
            $logo = url('img/logo.png');
            $instagram = url('img/instagram.jpeg');
            $linkedin = url('img/linkedin-logo.png');
            $twitter = url('img/twitter.jpeg');
            $list = [
                '[Name]' => Auth::user()->full_name,
                '[Logo]' => $logo,
                '[OTP]' => $code,
                '[Footer_Logo]' => $logo,
                '[Subject]' => $subject,
                '[instagram]' => $instagram,
                '[linkedin]' => $linkedin,
                '[twitter]' => $twitter,
            ];
            $emailTemplate = str_ireplace(array_keys($list), array_values($list), $body);
            Mail::to(auth()->user()->email)->send(new SendCodeMail($emailTemplate));
        } catch (Exception $e) {
            info('Error: ' . $e->getMessage());
        }
    }
}
