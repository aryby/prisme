<?php

namespace App\Observers;

use App\Mail\ReviewerPaperAssigned;
use App\Models\Review;
use Illuminate\Support\Facades\Mail;

class ReviewObserver
{
    public function created(Review $review): void
    {
        $this->sendAssignmentEmail($review);
    }

    public function updated(Review $review): void
    {
        if ($review->wasChanged('reviewer_id')) {
            $this->sendAssignmentEmail($review);
        }
    }

    private function sendAssignmentEmail(Review $review): void
    {
        if (! $review->reviewer_id) {
            return;
        }

        Mail::to($review->reviewer->email)->send(new ReviewerPaperAssigned($review));
    }
}
