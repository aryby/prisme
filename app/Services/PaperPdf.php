<?php

namespace App\Services;

use App\Models\Paper;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaperPdf
{
    public function view(Paper $paper): StreamedResponse
    {
        return $this->respond($paper, false);
    }

    public function download(Paper $paper): StreamedResponse
    {
        return $this->respond($paper, true);
    }

    private function respond(Paper $paper, bool $download): StreamedResponse
    {
        abort_unless(filled($paper->file_path), 404);

        $disk = Storage::disk($paper->file_disk ?: 'public');
        abort_unless($disk->exists($paper->file_path), 404);

        $filename = basename($paper->file_path);
        $headers = [
            'Content-Type' => 'application/pdf',
            'X-Content-Type-Options' => 'nosniff',
        ];

        if ($download) {
            return $disk->download($paper->file_path, $filename, $headers);
        }

        return $disk->response($paper->file_path, $filename, $headers, 'inline');
    }
}
