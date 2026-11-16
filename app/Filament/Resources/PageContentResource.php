<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageContentResource\Pages\EditPageContent;
use App\Filament\Resources\PageContentResource\Pages\ListPageContents;
use App\Models\PageContent;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PageContentResource extends Resource
{
    protected static ?string $model = PageContent::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|\UnitEnum|null $navigationGroup = 'System Management';

    protected static ?string $navigationLabel = 'Static Pages';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Page section')
                    ->schema([
                        Forms\Components\TextInput::make('label')
                            ->label('Content area')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\Textarea::make('content')
                            ->label('Text')
                            ->rows(8)
                            ->required()
                            ->maxLength(20000)
                            ->columnSpanFull(),
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
        ];
    }
}
