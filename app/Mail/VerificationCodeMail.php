<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class VerificationCodeMail extends Mailable
{
    public string $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function build()
    {
        return $this->subject('Verification Code')
            ->view('emails.verify-code')
            ->with([
                'code' => $this->code,
            ]);
    }
}
