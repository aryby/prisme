<?php

namespace App\Filament\Widgets;

use App\Models\PageContent;
use Filament\Widgets\Widget;

class SubmissionSettingsWidget extends Widget
{
    protected string $view = 'filament.widgets.submission-settings-widget';

    protected int|string|array $columnSpan = 'full';

    public bool $submissionsEnabled = true;

    public string $notification = '';

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function mount(): void
    {
        $this->submissionsEnabled = PageContent::submissionsEnabled();
    }

    public function toggleSubmissions(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403);

        $setting = PageContent::query()->firstOrCreate(
            ['key' => 'submission.enabled'],
            [
                'label' => 'Submission — accept paper submissions',
                'content' => '1',
            ],
        );

        $setting->content = $setting->content === '1' ? '0' : '1';
        $setting->save();

        $this->submissionsEnabled = $setting->content === '1';
        $this->notification = $this->submissionsEnabled
            ? 'Paper submissions are now enabled.'
            : 'Paper submissions are now disabled.';
    }
}
