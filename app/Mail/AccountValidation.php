<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class AccountValidation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function build(): self
    {
        return $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Verify your account')
            ->view('emails.account-validation', [
                'user' => $this->user,
                'verificationUrl' => URL::signedRoute('verification.verify', [
                    'id' => $this->user->getKey(),
                    'hash' => sha1($this->user->getEmailForVerification()),
                ]),
            ]);
    }
}
