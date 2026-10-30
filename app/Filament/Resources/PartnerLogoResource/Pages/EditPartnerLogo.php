<?php

namespace App\Filament\Resources\PartnerLogoResource\Pages;

use App\Filament\Resources\PartnerLogoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPartnerLogo extends EditRecord
{
    protected static string $resource = PartnerLogoResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (str_starts_with($data['image'] ?? '', 'partnes/')) {
            $data['image'] = null;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['image'] = $data['image'] ?: $this->getRecord()->image;

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
