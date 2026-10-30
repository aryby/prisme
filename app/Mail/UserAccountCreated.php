<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class UserAccountCreated extends Mailable
{
    public function __construct(
        public User $user,
        public string $password,
    ) {}

    public function build(): self
    {
        return $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Your Siprisme account has been created')
            ->view('emails.user-account-created', [
                'user' => $this->user,
                'password' => $this->password,
                'loginUrl' => route('login'),
            ]);
    }
}
