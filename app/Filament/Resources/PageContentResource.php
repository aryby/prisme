<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageContentResource\Pages\EditPageContent;
use App\Filament\Resources\PageContentResource\Pages\ListPageContents;
use App\Models\PageContent;
use Ferga\FilamentBuilder\Filament\Actions\OpenCanvasAction;
use Ferga\FilamentBuilder\Forms\Components\PageBuilder;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PageContentResource extends Resource
{
    protected static ?string $model = PageContent::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|\UnitEnum|null $navigationGroup = 'Website Content';

    protected static ?string $navigationLabel = 'Other Page Content';

    protected static ?int $navigationSort = 10;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereNotIn('key', [
                'committee.organizing',
                'committee.title',
                'committee.description',
                'committee.page',
                'site.logo',
                'site.header-title',
                'site.header-details',
                'program.title',
                'program.description',
                'program.page',
                'program.intro',
                'program.schedule',
                'program.contact',
            ]);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components(fn (?PageContent $record): array => [
                Section::make('Page section')
                    ->schema([
                        Forms\Components\TextInput::make('label')
                            ->label('Content area')
                            ->disabled()
                            ->dehydrated(false),
                        match ($record?->key) {
                            'committee.title' => Forms\Components\TextInput::make('content')
                                ->label('Page title')
                                ->required()
                                ->maxLength(20000),
                            'committee.description' => Forms\Components\Textarea::make('content')
                                ->label('Page description')
                                ->rows(3)
                                ->required()
                                ->maxLength(20000)
                                ->columnSpanFull(),
                            'committee.page' => PageBuilder::make('builder_content')
                                ->label('Committee page content')
                                ->blocks(['section', 'heading', 'rich_text', 'cards', 'highlights', 'image', 'image_text', 'gallery', 'quote', 'divider', 'spacer'])
                                ->columnSpanFull(),
                            'submission.enabled' => Forms\Components\Toggle::make('content')
                                ->label('Accept paper submissions')
                                ->formatStateUsing(fn (?string $state): bool => $state === '1')
                                ->dehydrateStateUsing(fn (bool $state): string => $state ? '1' : '0')
                                ->helperText('When disabled, visitors cannot submit papers.'),
                            default => match (true) {
                                str_starts_with((string) $record?->key, 'submission.') =>
                                    Forms\Components\Toggle::make('content')
                                        ->label('Enabled')
                                        ->formatStateUsing(fn (?string $state): bool => $state === '1')
                                        ->dehydrateStateUsing(fn (bool $state): string => $state ? '1' : '0'),
                                filled($record?->key) =>
                                    PageBuilder::make('builder_content')
                                        ->label('Multilingual page content')
                                        ->blocks(['heading', 'rich_text', 'cards', 'highlights', 'image', 'image_text', 'gallery', 'quote', 'divider', 'spacer'])
                                        ->columnSpanFull(),
                                default => Forms\Components\Textarea::make('content')
                                    ->label('Text')
                                    ->rows(8)
                                    ->required()
                                    ->maxLength(20000)
                                    ->columnSpanFull(),
                            },
                        },
                    ])
                    ->columns(2),
            ]);
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return static::canViewAny();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('Page section')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Current text')
                    ->limit(100)
                    ->wrap(),
            ])
            ->defaultSort('key')
            ->actions([
                \Filament\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPageContents::route('/'),
            'edit' => EditPageContent::route('/{record}/edit'),
            'builder' => \App\Filament\Resources\PageContentResource\Pages\PageContentBuilderCanvas::route('/{record}/builder'),
        ];
    }
}
