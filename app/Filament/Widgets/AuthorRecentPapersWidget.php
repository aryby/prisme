<?php

namespace App\Filament\Widgets;

use App\Models\Paper;
use Auth;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AuthorRecentPapersWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $user = Auth::user();

        return $table
            ->query(Paper::query()->where('author_id', $user?->id ?? 0)->latest()->limit(5))
            ->columns([
                TextColumn::make('title')
                    ->label('Paper')
                    ->searchable()
                    ->limit(45),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        'under_review' => 'warning',
                        'submitted' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state))),
                TextColumn::make('track')
                    ->label('Track')
                    ->sortable(),
                TextColumn::make('submitted_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('downloadCertificate')
                    ->label('Download certificate')
                    ->icon('heroicon-o-academic-cap')
                    ->url(fn (Paper $record): string => route('author.papers.certificate', $record))
                    ->visible(fn (Paper $record): bool => filled($record->certificate_path)
                        && $record->author_id === Auth::id()),
            ])
            ->paginated(false);
    }
}
