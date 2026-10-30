<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Services\PaperPdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaperPreviewController extends Controller
{
    public function __invoke(Paper $paper, Request $request, PaperPdf $pdf): StreamedResponse
    {
        abort_unless(auth()->user()?->isAdmin(), 403);

        return $request->boolean('download') ? $pdf->download($paper) : $pdf->view($paper);
    }
}
