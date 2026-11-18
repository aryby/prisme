<?php

namespace App\Filament\Pages;

use App\Models\PageContent;
use Ferga\FilamentBuilder\FergaBuilder;
use Ferga\FilamentBuilder\Forms\Components\PageBuilder;
use Filament\Actions\Action;
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

    protected function getHeaderActions(): array
    {
        $record = PageContent::query()->where('key', 'committee.page')->first();

        return $record ? [
            Action::make('openBuilder')
                ->label('Open visual builder')
                ->icon('heroicon-o-paint-brush')
                ->url(\App\Filament\Resources\PageContentResource::getUrl(
                    'builder',
                    ['record' => $record],
                )),
        ] : [];
    }

    public function mount(): void
    {
        $record = PageContent::query()->where('key', 'committee.page')->first();
        $documents = app(FergaBuilder::class)->normalizeDocuments($record?->builder_content);

        if ($documents === []) {
            $legacyContent = PageContent::text('committee.page');
            $documents = $legacyContent !== ''
                ? ['en' => [['type' => 'rich_text', 'data' => ['body' => $legacyContent]]]]
                : [];
        }

        $this->form->fill([
            'title' => PageContent::text('committee.title'),
            'description' => PageContent::text('committee.description'),
            'content' => $documents,
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
                    ->description('Build the committee page with the multilingual visual editor.')
                    ->schema([
                        PageBuilder::make('content')
                            ->blocks(['section', 'heading', 'rich_text', 'cards', 'highlights', 'divider', 'spacer'])
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
        ] as $key => $fieldName) {
            PageContent::query()->updateOrCreate(
                ['key' => $key],
                [
                    'label' => $fields[$key]['label'],
                    'content' => $data[$fieldName],
                ],
            );
        }

        $pageRecord = PageContent::query()->where('key', 'committee.page')->first();
        $documents = $data['content'] ?? [];

        if ($pageRecord) {
            $pageRecord->update(['builder_content' => $documents]);
        } else {
            $pageRecord = PageContent::query()->create([
                'key' => 'committee.page',
                'label' => config('page-content.committee.page.label'),
                'builder_content' => $documents,
                'content' => '',
            ]);
        }

        $legacyHtml = collect($documents['en'] ?? [])
            ->map(fn (array $block): string => $block['type'] === 'rich_text'
                ? (string) ($block['data']['body'] ?? '')
                : '')
            ->filter()
            ->implode("\n");

        $pageRecord->update(['content' => $legacyHtml]);

        Notification::make()
            ->title('Committee page saved')
            ->success()
            ->send();
    }
}
