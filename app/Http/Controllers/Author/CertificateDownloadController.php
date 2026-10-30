<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CertificateDownloadController extends Controller
{
    public function __invoke(Paper $paper): StreamedResponse
    {
        abort_unless(
            auth()->user()?->isAuthor() && $paper->author_id === auth()->id(),
            404,
        );

        abort_unless(filled($paper->certificate_path), 404);

        $disk = Storage::disk('local');
        abort_unless($disk->exists($paper->certificate_path), 404);

        $filename = 'PRISME-2026-Certificate-'.Str::slug($paper->author->name).'.pdf';

        return $disk->download($paper->certificate_path, $filename, [
            'Content-Type' => 'application/pdf',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
