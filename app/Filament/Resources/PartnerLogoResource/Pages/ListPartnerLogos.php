<?php

namespace App\Filament\Resources\PartnerLogoResource\Pages;

use App\Filament\Resources\PartnerLogoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPartnerLogos extends ListRecords
{
    protected static string $resource = PartnerLogoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
