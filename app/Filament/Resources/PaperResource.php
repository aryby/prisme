<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaperResource\Pages\CreatePaper;
use App\Filament\Resources\PaperResource\Pages\EditPaper;
use App\Filament\Resources\PaperResource\Pages\ListPapers;
use App\Models\Paper;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PaperResource extends Resource
{
    protected static ?string $model = Paper::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|\UnitEnum|null $navigationGroup = 'Symposium Management';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Submission')
                    ->schema([
                        Forms\Components\Select::make('author_id')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('track')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('status')
                            ->options([
                                'submitted' => 'Submitted',
                                'under_review' => 'Under review',
                                'accepted' => 'Accepted',
                                'rejected' => 'Rejected',
                            ])
                            ->required(),
                        Forms\Components\Select::make('submission_option')
                            ->options([
                                'full_submission' => 'Full submission',
                                'abstract_submission' => 'Abstract submission',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('affiliation')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('country')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('paper_upload')
                            ->label('Paper PDF')
                            ->disk('local')
                            ->directory('papers')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(10240)
                            ->required(fn (?Paper $record): bool => ! filled($record?->file_path))
                            ->helperText('PDF only, maximum 10 MB.')
                            ->columnSpanFull(),
                        Forms\Components\DateTimePicker::make('submitted_at'),
                    ])
                    ->columns(2),
                Section::make('Abstract and keywords')
                    ->schema([
                        Forms\Components\Textarea::make('abstract')
                            ->rows(6)
                            ->required(),
                        Forms\Components\Textarea::make('keywords')
                            ->rows(3)
                            ->required(),
                    ]),
                Section::make('Reviewer assignments')
                    ->schema([
                        Forms\Components\Repeater::make('reviews')
                            ->relationship()
                            ->label('Assigned reviewers')
                            ->schema([
                                Forms\Components\Select::make('reviewer_id')
                                    ->label('Reviewer')
                                    ->options(fn (): array => User::query()
                                        ->where('role', 'reviewer')
                                        ->orderBy('name')
                                        ->pluck('name', 'id')
                                        ->all())
                                    ->searchable()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->required(),
                            ])
                            ->addActionLabel('Assign reviewer')
                            ->columns(1),
                    ])
                    ->visible(fn (): bool => auth()->user()?->isAdmin() ?? false),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->check() && auth()->user()->isAuthor() && ! auth()->user()->isAdmin()) {
            $query->where('author_id', auth()->id());
        }

        return $query;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable(),
                Tables\Columns\TextColumn::make('track')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        'under_review' => 'warning',
                        'submitted' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state))),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Submitted')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'submitted' => 'Submitted',
                        'under_review' => 'Under review',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('track')
                    ->options(fn () => Paper::query()->distinct()->pluck('track', 'track')->toArray()),
            ])
            ->actions([
                EditAction::make()
                    ->visible(fn (Paper $record): bool => auth()->user()?->isAdmin()
                        || $record->author_id === auth()->id()),
                Action::make('viewPdf')
                    ->label('View PDF')
                    ->icon('heroicon-o-document')
                    ->url(fn (Paper $record): string => auth()->user()?->isAdmin()
                        ? route('admin.papers.pdf', $record)
                        : route('author.papers.pdf', $record))
                    ->openUrlInNewTab()
                    ->visible(fn (Paper $record): bool => filled($record->file_path)
                        && (auth()->user()?->isAdmin()
                            || (auth()->user()?->isAuthor() && $record->author_id === auth()->id()))),
                Action::make('downloadPdf')
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Paper $record): string => (auth()->user()?->isAdmin()
                        ? route('admin.papers.pdf', $record)
                        : route('author.papers.pdf', $record)).'?download=1')
                    ->visible(fn (Paper $record): bool => filled($record->file_path)
                        && (auth()->user()?->isAdmin()
                            || (auth()->user()?->isAuthor() && $record->author_id === auth()->id()))),
                Action::make('downloadCertificate')
                    ->label('Download certificate')
                    ->icon('heroicon-o-academic-cap')
                    ->url(fn (Paper $record): string => route('author.papers.certificate', $record))
                    ->visible(fn (Paper $record): bool => filled($record->certificate_path)
                        && auth()->user()?->isAuthor()
                        && $record->author_id === auth()->id()),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->visible(fn (): bool => auth()->check() && auth()->user()?->isAdmin()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPapers::route('/'),
            'create' => CreatePaper::route('/create'),
            'edit' => EditPaper::route('/{record}/edit'),
        ];
    }
}
