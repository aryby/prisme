<?php

namespace App\Filament\Widgets;

use App\Models\Paper;
use App\Models\Registration;
use App\Models\Review;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $pendingReviews = Review::query()->where('status', 'pending')->count();
        $pendingRegistrations = Registration::query()->where('payment_status', 'pending')->count();
        $verifiedRegistrations = Registration::query()->where('payment_status', 'verified')->count();

        return [
            Stat::make('Total Papers', (string) Paper::query()->count())
                ->description('All submissions received')
                ->color('primary'),

            Stat::make('Registered Users', (string) User::query()->count())
                ->description('Accounts on the platform')
                ->color('success'),

            Stat::make('Registrations', (string) Registration::query()->count())
                ->description('Conference registrations in total')
                ->color('info'),

            Stat::make('Pending Reviews', (string) $pendingReviews)
                ->description("{$pendingRegistrations} pending payments • {$verifiedRegistrations} verified")
                ->color('warning'),

            Stat::make('Accepted Papers', (string) Paper::query()->where('status', 'accepted')->count())
                ->description('Approved submissions')
                ->color('success'),
        ];
    }
}
