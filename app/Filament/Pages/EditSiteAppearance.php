<?php

namespace App\Filament\Pages;

use App\Models\PageContent;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EditSiteAppearance extends Page
{
    protected static ?string $slug = 'site-appearance';

    protected static ?string $title = 'Site Appearance';

    protected static ?string $navigationLabel = 'Site Appearance';

    protected static string|\UnitEnum|null $navigationGroup = 'Website Content';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.edit-site-appearance';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function mount(): void
    {
        $this->form->fill([
            'logo' => PageContent::text('site.logo'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Website header')
                    ->description('Upload a logo for the public website header. Remove the uploaded image to use the original logo again.')
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Header logo')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->disk('public')
                            ->directory('site')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->imageEditor()
                            ->helperText('Upload a JPG, PNG, WebP, or SVG image up to 5 MB.')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403);

        $data = $this->form->getState();
        $fields = config('page-content');
        $field = $fields['site.logo'];

        PageContent::query()->updateOrCreate(
            ['key' => 'site.logo'],
            [
                'label' => $field['label'],
                'content' => $data['logo'] ?? '',
            ],
        );

        Notification::make()
            ->title('Site appearance saved')
            ->success()
            ->send();
    }
}
