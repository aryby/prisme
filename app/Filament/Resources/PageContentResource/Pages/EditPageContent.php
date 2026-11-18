<?php

namespace App\Filament\Resources\PageContentResource\Pages;

use App\Filament\Resources\PageContentResource;
use Ferga\FilamentBuilder\Filament\Actions\OpenCanvasAction;
use Filament\Resources\Pages\EditRecord;

class EditPageContent extends EditRecord
{
    protected static string $resource = PageContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            OpenCanvasAction::make()
                ->visible(fn ($record): bool => $record instanceof \App\Models\PageContent
                    && ! str_starts_with($record->key, 'submission.')
                    && ! in_array($record->key, [
                        'site.logo',
                        'site.header-title',
                        'site.header-details',
                        'committee.title',
                        'committee.description',
                        'program.title',
                        'program.description',
                    ], true)),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['builder_content']) && is_array($data['builder_content'])) {
            $data['content'] = \App\Models\PageContent::contentFromBuilder($data['builder_content']);
        }

        return $data;
    }
}
