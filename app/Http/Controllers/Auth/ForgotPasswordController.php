<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\EmailTemplate;
use App\Mail\ForgetPassword;
use App\Models\User;
use App\Http\Requests\Auth\ResetPasswordEmailRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;

class ForgotPasswordController extends Controller
{
    private const TOKEN_EXPIRY_MINUTES = 60;
    private const TOKEN_PREFIX_LENGTH = 8;

    public function forgetPassword()
    {
        return view('auth.forget-password');
    }

    public function forgetPasswordRequest(ResetPasswordEmailRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $token = Str::random(64);
        $tokenPrefix = substr($token, 0, self::TOKEN_PREFIX_LENGTH);

        DB::table('password_resets')->where('email', $request->email)->delete();

        $saveToken = DB::table('password_resets')->updateOrInsert([
            'email' => $request->email,
        ], [
            'token' => Hash::make($token),
            'token_prefix' => $tokenPrefix,
            'created_at' => Carbon::now(),
        ]);

        if ($saveToken) {
            $template = EmailTemplate::where('slug', 'forgot_password')->first();
            $body = $template->description;
            $subject = $template->subject;
            $logo = getSiteLogo();
            $instagram = url('img/instagram.jpeg');
            $linkedin = url('img/linkedin-logo.png');
            $twitter = url('img/twitter.jpeg');
            $list = [
                '[Name]' => $user->full_name,
                '[Logo]' => $logo,
                '[Footer_Logo]' => $logo,
                '[Subject]' => $subject,
                '[Email]' => $user->email,
                '[instagram]' => $instagram,
                '[linkedin]' => $linkedin,
                '[twitter]' => $twitter,
                '[Reset Password Link]' => url('admin/reset-password/' . $token),
            ];

            $emailTemplate = str_ireplace(array_keys($list), array_values($list), $body);
            Mail::to($request['email'])->send(new ForgetPassword($request->email, $emailTemplate));
        }

        return redirect()->route('forget.password')
            ->with('success', 'Please check your email for password reset.');
    }

    public function ResetLoginPassword($token)
    {
        if (!$this->findValidResetRecord($token)) {
            return redirect()->route('admin.login')->with('error', 'Invalid or expired reset link.');
        }

        return view('auth.reset-password', ['token' => $token]);
    }

    public function changePassword(UpdatePasswordRequest $request)
    {
        $resetRecord = $this->findValidResetRecord($request->token);

        if ($resetRecord) {
            User::where('email', $resetRecord->email)->update([
                'password' => Hash::make($request->new_password),
            ]);

            DB::table('password_resets')->where('email', $resetRecord->email)->delete();

            return redirect()->route('admin.login')->with('success', 'You have successfully changed your password');
        }

        return redirect()->route('admin.login')->with('error', 'Invalid or expired token');
    }

    private function findValidResetRecord(string $token): ?object
    {
        if (strlen($token) < self::TOKEN_PREFIX_LENGTH) {
            return null;
        }

        $tokenPrefix = substr($token, 0, self::TOKEN_PREFIX_LENGTH);

        $resetRecord = DB::table('password_resets')
            ->where('token_prefix', $tokenPrefix)
            ->where('created_at', '>=', now()->subMinutes(self::TOKEN_EXPIRY_MINUTES))
            ->first();

        if (!$resetRecord || !Hash::check($token, $resetRecord->token)) {
            return null;
        }

        return $resetRecord;
    }
}
