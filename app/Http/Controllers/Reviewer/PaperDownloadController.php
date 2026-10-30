<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Services\PaperPdf;
use App\Models\Review;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaperDownloadController extends Controller
{
    public function __invoke(Review $review, Request $request, PaperPdf $pdf): StreamedResponse
    {
        abort_unless(
            auth()->user()?->isReviewer() && $review->reviewer_id === auth()->id(),
            404,
        );

        return $request->boolean('download')
            ? $pdf->download($review->paper)
            : $pdf->view($review->paper);
    }
}
