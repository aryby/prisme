<?php

namespace App\Providers\Filament;

use App\Filament\Pages\EditProfile;
use App\Filament\Resources\PaperResource;
use App\Filament\Widgets\AuthorOverviewWidget;
use App\Filament\Widgets\AuthorRecentPapersWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AuthorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('author')
            ->path('author/dashboard')
            ->login()
            ->profile(EditProfile::class)
            ->brandName('Siprisme Author')
            ->colors([
                'primary' => '#0f766e',
                'danger' => '#dc2626',
                'gray' => '#475569',
                'success' => '#16a34a',
                'warning' => '#f59e0b',
            ])
            ->navigationGroups([
                NavigationGroup::make('Overview'),
                NavigationGroup::make('My Submissions'),
                NavigationGroup::make('Account'),
            ])
            ->pages([
                Dashboard::class,
            ])
            ->resources([
                PaperResource::class,
            ])
            ->widgets([
                AuthorOverviewWidget::class,
                AuthorRecentPapersWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
