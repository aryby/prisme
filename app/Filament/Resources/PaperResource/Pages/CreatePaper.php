<?php

namespace App\Filament\Resources\PaperResource\Pages;

use App\Filament\Resources\PaperResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePaper extends CreateRecord
{
    protected static string $resource = PaperResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['file_path'] = $data['paper_upload'];
        $data['file_disk'] = 'local';
        unset($data['paper_upload']);

        return $data;
    }
}
