<?php

namespace App\Filament\Resources\ReviewResource\Pages;

use App\Filament\Resources\ReviewResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditReview extends EditRecord
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewPaper')
                ->label('View paper PDF')
                ->icon('heroicon-o-document')
                ->url(fn (): string => route('reviewer.reviews.paper', ['review' => $this->record]))
                ->openUrlInNewTab()
                ->visible(fn (): bool => auth()->user()?->isReviewer()
                    && filled($this->record->paper->file_path)),
            Action::make('downloadPaper')
                ->label('Download paper PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn (): string => route('reviewer.reviews.paper', ['review' => $this->record]).'?download=1')
                ->visible(fn (): bool => auth()->user()?->isReviewer()
                    && filled($this->record->paper->file_path)),
        ];
    }
}
