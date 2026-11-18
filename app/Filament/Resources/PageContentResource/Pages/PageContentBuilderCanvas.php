<?php

namespace App\Filament\Resources\PageContentResource\Pages;

use App\Filament\Resources\PageContentResource;
use App\Models\PageContent;
use Ferga\FilamentBuilder\Filament\Pages\BuilderCanvas;
use Illuminate\Database\Eloquent\Model;

class PageContentBuilderCanvas extends BuilderCanvas
{
    protected static string $resource = PageContentResource::class;

    protected static string $contentField = 'builder_content';

    public function getBackUrl(): ?string
    {
        return match ($this->getRecord()->key) {
            'committee.page' => route('filament.admin.pages.committee-page'),
            'program.page' => route('filament.admin.pages.program-page'),
            default => parent::getBackUrl(),
        };
    }

    protected function resolveRecord(int|string $key): Model
    {
        return PageContent::query()->findOrFail($key);
    }

    public function save(): void
    {
        parent::save();

        $this->getRecord()->syncContentFromBuilder();
    }
}
