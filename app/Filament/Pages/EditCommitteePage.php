<?php

namespace App\Filament\Pages;

use App\Models\PageContent;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EditCommitteePage extends Page
{
    protected static ?string $slug = 'committee-page';

    protected static ?string $title = 'Committee Page';

    protected static ?string $navigationLabel = 'Committee Page';

    protected static string|\UnitEnum|null $navigationGroup = 'Website Content';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.edit-committee-page';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function mount(): void
    {
        $this->form->fill([
            'title' => PageContent::text('committee.title'),
            'description' => PageContent::text('committee.description'),
            'content' => PageContent::text('committee.page'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Page details')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->rows(3)
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Committee content')
                    ->description('Edit all committee headings, member lists, and contact details here.')
                    ->schema([
                        RichEditor::make('content')
                            ->required()
                            ->maxLength(50000)
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

        foreach ([
            'committee.title' => 'title',
            'committee.description' => 'description',
            'committee.page' => 'content',
        ] as $key => $fieldName) {
            PageContent::query()->updateOrCreate(
                ['key' => $key],
                [
                    'label' => $fields[$key]['label'],
                    'content' => $data[$fieldName],
                ],
            );
        }

        Notification::make()
            ->title('Committee page saved')
            ->success()
            ->send();
    }
}
