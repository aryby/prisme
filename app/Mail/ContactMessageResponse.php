<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Mail\Mailable;

class ContactMessageResponse extends Mailable
{
    public function __construct(public ContactMessage $contactMessage) {}

    public function build(): self
    {
        return $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Response to your PRISME 2026 message: '.$this->contactMessage->subject)
            ->view('emails.contact-message-response', [
                'contactMessage' => $this->contactMessage,
            ]);
    }
}
