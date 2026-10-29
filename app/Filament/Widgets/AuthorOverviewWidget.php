<?php

namespace App\Filament\Widgets;

use App\Models\Paper;
use Auth;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AuthorOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        $papers = $user ? $user->papers()->get() : collect();

        return [
            Stat::make('Total papers', (string) $papers->count())
                ->description('All submissions')
                ->color('primary'),
            Stat::make('Submitted', (string) $papers->where('status', 'submitted')->count())
                ->description('Pending initial upload')
                ->color('info'),
            Stat::make('Under review', (string) $papers->where('status', 'under_review')->count())
                ->description('Currently being evaluated')
                ->color('warning'),
            Stat::make('Accepted', (string) $papers->where('status', 'accepted')->count())
                ->description('Approved papers')
                ->color('success'),
            Stat::make('Rejected', (string) $papers->where('status', 'rejected')->count())
                ->description('Declined submissions')
                ->color('danger'),
        ];
    }
}
