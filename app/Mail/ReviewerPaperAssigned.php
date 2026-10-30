<?php

namespace App\Mail;

use App\Models\Review;
use Illuminate\Mail\Mailable;

class ReviewerPaperAssigned extends Mailable
{
    public function __construct(public Review $review) {}

    public function build(): self
    {
        return $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('A paper has been assigned to you for review')
            ->view('emails.reviewer-paper-assigned', [
                'review' => $this->review,
                'paper' => $this->review->paper,
                'reviewUrl' => route('filament.reviewer.resources.reviews.edit', [
                    'record' => $this->review,
                ]),
                'paperUrl' => route('reviewer.reviews.paper', [
                    'review' => $this->review,
                ]),
            ]);
    }
}
