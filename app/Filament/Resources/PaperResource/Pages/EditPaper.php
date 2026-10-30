<?php

namespace App\Filament\Resources\PaperResource\Pages;

use App\Models\Paper;
use App\Filament\Resources\PaperResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPaper extends EditRecord
{
    protected static string $resource = PaperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewPdf')
                ->label('View PDF')
                ->icon('heroicon-o-document')
                ->url(fn (): string => auth()->user()?->isAdmin()
                    ? route('admin.papers.pdf', $this->record)
                    : route('author.papers.pdf', $this->record))
                ->openUrlInNewTab()
                ->visible(fn (): bool => filled($this->record->file_path)
                    && (auth()->user()?->isAdmin()
                        || (auth()->user()?->isAuthor() && $this->record->author_id === auth()->id()))),
            Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn (): string => (auth()->user()?->isAdmin()
                    ? route('admin.papers.pdf', $this->record)
                    : route('author.papers.pdf', $this->record)).'?download=1')
                ->visible(fn (): bool => filled($this->record->file_path)
                    && (auth()->user()?->isAdmin()
                        || (auth()->user()?->isAuthor() && $this->record->author_id === auth()->id()))),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (filled($data['paper_upload'] ?? null)) {
            $data['file_path'] = $data['paper_upload'];
            $data['file_disk'] = 'local';
        }

        unset($data['paper_upload']);

        return $data;
    }
}
