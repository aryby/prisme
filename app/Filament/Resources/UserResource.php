<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|\UnitEnum|null $navigationGroup = 'People';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profile')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Placeholder::make('password_notice')
                            ->label('Password')
                            ->content('A secure password will be generated and emailed to the user.')
                            ->visibleOn('create')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('role')
                            ->options([
                                'admin' => 'Admin',
                                'author' => 'Author',
                                'reviewer' => 'Reviewer',
                            ])
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'pending' => 'Pending',
                                'suspended' => 'Suspended',
                            ])
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active account')
                            ->default(false),
                    ])
                    ->columns(2),
                Section::make('Sent email history')
                    ->schema([
                        Forms\Components\Placeholder::make('sent_email_history')
                            ->hiddenLabel()
                            ->content(fn (?User $record): HtmlString => new HtmlString(
                                view('filament.resources.users.email-history', [
                                    'messages' => $record?->sentMessages ?? collect(),
                                ])->render(),
                            ))
                            ->columnSpanFull(),
                    ])
                    ->visibleOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'primary',
                        'reviewer' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'pending' => 'warning',
                        'suspended' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Enabled')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Filter by role')
                    ->options([
                        'admin' => 'Admin',
                        'author' => 'Author',
                        'reviewer' => 'Reviewer',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'pending' => 'Pending',
                        'suspended' => 'Suspended',
                    ]),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
