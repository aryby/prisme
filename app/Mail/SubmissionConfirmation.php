<?php

namespace App\Mail;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmissionConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Paper $paper,
        public ?string $password,
    ) {}

    public function build(): self
    {
        return $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Your paper submission has been received')
            ->view('emails.submission-confirmation', [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'paper' => $this->paper,
                'password' => $this->password,
            ]);
    }
}
