<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\EmailTemplate;
use App\Mail\ForgetPassword;
use App\Models\User;
use App\Http\Requests\Auth\ResetPasswordEmailRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;

class ForgotPasswordController extends Controller
{
    /* display forget password request link blade */
    public function forgetPassword()
    {
        return view('auth.foget-password');
    }
    /* send reset password link through an email */
    /* use required and exists validation for requested email  */
    /* check in password resets table that email exist or not */
    /* if email exists  ,delete that record first ,then create new record */
    /* then send reset password link through an email  */
    public function forgetPasswordRequest(ResetPasswordEmailRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $token = Str::random(64);
        DB::table('password_resets')->where('email', $request->email)->delete();

        $saveToken = DB::table('password_resets')->updateOrInsert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        if ($saveToken) {
            $template = EmailTemplate::where('slug', 'forgot_password')->first();
            $body = $template->description;
            $subject = $template->subject;
            $tokenlink = $token;
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
                '[twitter]' =>  $twitter,
                '[Reset Password Link]' => url('admin/reset-password/' . $tokenlink),
            ];

            $find = array_keys($list);
            $replace = array_values($list);
            $email_template = str_ireplace($find, $replace, $body);
            Mail::to($request["email"])->send(new ForgetPassword($request->email, $token, $email_template));
        }

        return redirect()->route('forget.password')
            ->with('success', 'Please check your email for password reset.');
    }

    /* show password update form  */
    public function ResetLoginPassword($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /* update password using required validation for new password and confirm password */
    public function changePassword(UpdatePasswordRequest $request)
    {
        $user = DB::table('password_resets')->select('email')->where('token', $request->token)->first();
        if ($user) {
            User::where("email", $user->email)->update([
                'password' => bcrypt($request->new_password),
            ]);
            return redirect()->route('admin.login')->with('success', 'You have successfully changed your password');
        }
        return redirect()->route('admin.login')->with('error', 'Invalid token');
    }
}
