<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerLogoResource\Pages\CreatePartnerLogo;
use App\Filament\Resources\PartnerLogoResource\Pages\EditPartnerLogo;
use App\Filament\Resources\PartnerLogoResource\Pages\ListPartnerLogos;
use App\Models\PartnerLogo;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PartnerLogoResource extends Resource
{
    protected static ?string $model = PartnerLogo::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static string|\UnitEnum|null $navigationGroup = 'Website Content';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Partner logo')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('image')
                            ->label('Logo image')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->disk('public')
                            ->directory('partner-logos')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->required(fn (?PartnerLogo $record): bool => $record === null || ! filled($record->image))
                            ->helperText('Upload a JPG, PNG, or WebP logo up to 5 MB. Existing site logos can be replaced here.')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('url')
                            ->label('Website link')
                            ->url()
                            ->maxLength(255)
                            ->nullable()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Display order')
                            ->numeric()
                            ->integer()
                            ->minValue(0)
                            ->default(0)
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Visible on website')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canCreate(): bool
    {
        return static::canViewAny();
    }

    public static function canEdit(Model $record): bool
    {
        return static::canViewAny();
    }

    public static function canDelete(Model $record): bool
    {
        return static::canViewAny();
    }

    public static function canDeleteAny(): bool
    {
        return static::canViewAny();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Logo')
                    ->imageHeight(50),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Visible'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPartnerLogos::route('/'),
            'create' => CreatePartnerLogo::route('/create'),
            'edit' => EditPartnerLogo::route('/{record}/edit'),
        ];
    }
}
