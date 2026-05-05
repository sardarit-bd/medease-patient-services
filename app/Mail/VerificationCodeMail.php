<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;


class PasswordResetCodeMail extends Mailable
{
    public function build()
    {
        return $this->subject('Password Reset Code')
            ->view('emails.password-reset-code');
    }
}
