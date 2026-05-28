<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerifyTemplate extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $email;
    public string $content;

    public function __construct(string $email, string $token)
    {
        $this->email = $email;
        $this->content = $token;
    }

    public function build()
    {
        return $this->subject('Verify your email address')
            ->view('auth.forget-password-email');
    }
}
