<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCodeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $emailTemplate;

    public function __construct(string $emailTemplate)
    {
        $this->emailTemplate = $emailTemplate;
    }

    public function build()
    {
        return $this->markdown('emails.common', [
            'email_template' => sanitizeEmailHtml($this->emailTemplate),
        ]);
    }
}
