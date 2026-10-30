<?php

namespace App\Mail;

use App\Models\Paper;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Str;

class PaperCertificate extends Mailable
{
    public function __construct(
        public Paper $paper,
        public string $emailSubject,
        public string $emailMessage,
    ) {}

    public function build(): self
    {
        return $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject($this->emailSubject)
            ->view('emails.paper-certificate', [
                'paper' => $this->paper,
                'author' => $this->paper->author,
                'emailMessage' => $this->emailMessage,
            ])
            ->attachFromStorageDisk(
                'local',
                $this->paper->certificate_path,
                'PRISME-2026-Certificate-'.Str::slug($this->paper->author->name).'.pdf',
                ['mime' => 'application/pdf'],
            );
    }
}
