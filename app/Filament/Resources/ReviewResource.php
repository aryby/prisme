<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages\CreateReview;
use App\Filament\Resources\ReviewResource\Pages\EditReview;
use App\Filament\Resources\ReviewResource\Pages\ListReviews;
use App\Models\Paper;
use App\Models\Review;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string|\UnitEnum|null $navigationGroup = 'Under Review Papers';

    protected static ?int $navigationSort = 1;

    // navigation title name = "Under Review Papers" 
    protected static ?string $navigationLabel = 'Under Review Papers';

    public static function form(Schema $schema): Schema
    {
        $isReviewer = auth()->user()?->isReviewer() ?? false;

        return $schema
            ->components([
                Section::make('Assignment')
                    ->schema([
                        Forms\Components\Select::make('paper_id')
                            ->label('Paper')
                            ->options(fn (): array => Paper::query()
                                ->orderBy('title')
                                ->pluck('title', 'id')
                                ->all())
                            ->searchable()
                            ->required()
                            ->disabled($isReviewer)
                            ->dehydrated(! $isReviewer),
                        Forms\Components\Select::make('reviewer_id')
                            ->label('Reviewer')
                            ->options(fn (): array => User::query()
                                ->where('role', 'reviewer')
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->all())
                            ->searchable()
                            ->required()
                            ->visible(! $isReviewer),
                        Forms\Components\Placeholder::make('paper_abstract')
                            ->label('Abstract')
                            ->content(fn (?Model $record): string => $record instanceof Review
                                ? $record->paper->abstract
                                : 'The paper abstract will be available after assignment.')
                            ->visible($isReviewer)
                            ->columnSpanFull(),
                        Forms\Components\Placeholder::make('paper_keywords')
                            ->label('Keywords')
                            ->content(fn (?Model $record): string => $record instanceof Review
                                ? $record->paper->keywords
                                : '')
                            ->visible($isReviewer)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Review')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Review decision')
                            ->options([
                                'pending' => 'Pending',
                                'accepted' => 'Recommend acceptance',
                                'rejected' => 'Recommend rejection',
                                'revision_required' => 'Revision required',
                            ])
                            ->default('pending')
                            ->required(),
                        Forms\Components\TextInput::make('score')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->maxValue(5)
                            ->helperText('Optional score from 1 to 5.'),
                        Forms\Components\Repeater::make('reviewComments')
                            ->relationship()
                            ->label('Comments')
                            ->schema([
                                Forms\Components\Textarea::make('body')
                                    ->label('Comment')
                                    ->rows(4)
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->addActionLabel('Add comment')
                            ->required(fn (Get $get): bool => $get('status') !== 'pending')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()?->isReviewer()) {
            $query->where('reviewer_id', auth()->id());
        }

        return $query;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paper.title')
                    ->label('Paper')
                    ->searchable()
                    ->sortable()
                    ->url(fn (Review $record): ?string => auth()->user()?->isReviewer()
                        ? route('filament.reviewer.resources.reviews.edit', ['record' => $record])
                        : null)
                    ->limit(45),
                Tables\Columns\TextColumn::make('paper.track')
                    ->label('Track')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('reviewer.name')
                    ->label('Reviewer')
                    ->visible(fn (): bool => auth()->user()?->isAdmin() ?? false)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        'revision_required' => 'warning',
                        'pending' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'accepted' => 'Recommend acceptance',
                        'rejected' => 'Recommend rejection',
                        'revision_required' => 'Revision required',
                        default => ucfirst($state),
                    }),
                Tables\Columns\TextColumn::make('score')
                    ->label('Score')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('review_comments_count')
                    ->label('Comments')
                    ->counts('reviewComments')
                    ->sortable()
                    ->placeholder('Not reviewed yet')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last updated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                EditAction::make()
                    ->label('Write review')
                    ->icon('heroicon-o-pencil-square'),
                Action::make('viewPaper')
                    ->label('View paper PDF')
                    ->icon('heroicon-o-document')
                    ->url(fn (Review $record): string => route('reviewer.reviews.paper', ['review' => $record]))
                    ->openUrlInNewTab()
                    ->visible(fn (Review $record): bool => auth()->user()?->isReviewer()
                        && filled($record->paper->file_path)),
                Action::make('downloadPaper')
                    ->label('Download paper PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Review $record): string => route('reviewer.reviews.paper', ['review' => $record]).'?download=1')
                    ->visible(fn (Review $record): bool => auth()->user()?->isReviewer()
                        && filled($record->paper->file_path)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReviews::route('/'),
            'create' => CreateReview::route('/create'),
            'edit' => EditReview::route('/{record}/edit'),
        ];
    }
}
