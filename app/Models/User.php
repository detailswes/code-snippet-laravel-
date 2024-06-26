<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Filters\UserFilter;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\NextAndPrevious;
use Storage;
use App\Models\LoginOtp;
use Mail;
use Auth;
use App\Mail\SendCodeMail;
use App\Traits\HasPermissionsTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Filterable, NextAndPrevious, HasPermissionsTrait;

    const ADMIN = 'admin';
    const USER = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role_id',
        'status',
        'original_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['full_name', 'profile_image_path'];


    public function isAdmin(): bool
    {
        return  $this->role->slug === self::ADMIN;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function scopeIsNotSuperAdmin($query)
    {
        return $query->where('email', '!=', 'admin@admin.com');
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
            get: fn () =>  optional($this->files()->where('type', 'profile_image')->first())->path,
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

    public function fullOriginaiProfileImagePath()
    {
        if ($this->original_path) {
            return Storage::url($this->original_path);
        }
        return url('../img/admin.jpeg');
    }
    /* generete otp  */
    public function generateCode()
    {
        $code = rand(1000, 9999);
        LoginOtp::updateOrCreate(
            ['user_id' => auth()->user()->id],
            ['code' => $code]
        );

        try {
            $email_template = [
                'title' => 'OTP verification email',
                'code' => $code
            ];
            $template = EmailTemplate::where('slug', 'OTP_Template')->first();
            $body = $template->description;
            $subject = $template->subject;
            $logo = url('img/logo.png');
            $instagram = url('img/instagram.jpeg');
            $linkedin = url('img/linkedin-logo.png');
            $twitter = url('img/twitter.jpeg');
            $Code = $code;
            $list = [
                '[Name]' => Auth::user()->full_name,
                '[Logo]' => $logo,
                '[OTP]' => $Code,
                '[Footer_Logo]' => $logo,
                '[Subject]' => $subject,
                '[instagram]' => $instagram,
                '[linkedin]' => $linkedin,
                '[twitter]' =>  $twitter,
            ];
            $find = array_keys($list);
            $replace = array_values($list);
            $email_template = str_ireplace($find, $replace, $body);
            Mail::to(auth()->user()->email)->send(new SendCodeMail($email_template));
        } catch (Exception $e) {
            info("Error: " . $e->getMessage());
        }
    }
}
