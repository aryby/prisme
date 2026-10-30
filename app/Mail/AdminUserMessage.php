<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class AdminUserMessage extends Mailable
{
    public function __construct(
        public User $user,
        public string $messageSubject,
        public string $messageBody,
    ) {}

    public function build(): self
    {
        return $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject($this->messageSubject)
            ->view('emails.admin-user-message', [
                'user' => $this->user,
                'messageBody' => $this->messageBody,
            ]);
    }
}
