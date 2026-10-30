<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages\EditContactMessage;
use App\Filament\Resources\ContactMessageResource\Pages\ListContactMessages;
use App\Models\ContactMessage;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static string|\UnitEnum|null $navigationGroup = 'Symposium Management';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contact message')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('subject')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('message')
                            ->rows(8)
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Admin response')
                    ->schema([
                        Forms\Components\Textarea::make('response')
                            ->label('Response to contact')
                            ->rows(8)
                            ->helperText('Saving a new or edited response sends it to the contact email.')
                            ->columnSpanFull(),
                        Forms\Components\Placeholder::make('responded_at')
                            ->label('Last response sent')
                            ->content(fn (?ContactMessage $record): string => $record?->responded_at?->toDayDateTimeString()
                                ?? 'No response sent yet.'),
                    ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest();
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('responded_at')
                    ->label('Response sent')
                    ->dateTime()
                    ->placeholder('Awaiting response')
                    ->sortable(),
            ])
            ->actions([
                EditAction::make()
                    ->label('View and respond'),
            ])
            ->recordUrl(fn (ContactMessage $record): string => static::getUrl('edit', ['record' => $record]));
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactMessages::route('/'),
            'edit' => EditContactMessage::route('/{record}/edit'),
        ];
    }
}
