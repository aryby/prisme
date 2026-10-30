<?php

namespace App\Filament\Widgets;

use App\Models\Paper;
use App\Models\Review;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $pendingReviews = Review::query()->where('status', 'pending')->count();

        return [
            Stat::make('Total Papers', (string) Paper::query()->count())
                ->description('All submissions received')
                ->color('primary'),

            Stat::make('Registered Users', (string) User::query()->count())
                ->description('Accounts on the platform')
                ->color('success'),

            Stat::make('Pending Reviews', (string) $pendingReviews)
                ->description('Reviews awaiting completion')
                ->color('warning'),

            Stat::make('Accepted Papers', (string) Paper::query()->where('status', 'accepted')->count())
                ->description('Approved submissions')
                ->color('success'),
        ];
    }
}
