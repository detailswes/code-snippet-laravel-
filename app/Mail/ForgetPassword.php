<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgetPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $email;
    public string $email_template;

    public function __construct(string $email, string $emailTemplate)
    {
        $this->email = $email;
        $this->email_template = $emailTemplate;
    }

    public function build()
    {
        return $this->markdown('emails.common', [
            'email_template' => sanitizeEmailHtml($this->email_template),
        ]);
    }
}
