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
        $pendingReviews = Paper::query()->where('status', 'pending')->count();
        $rejectedReviews = Paper::query()->where('status', 'rejected')->count();
        $underReviewReviews = Paper::query()->where('status', 'under_review')->count();


        return [
            Stat::make('Total Papers', (string) Paper::query()->count())
                ->description('All submissions received')
                ->color('primary'),
                


            Stat::make('Accepted Papers', (string) Paper::query()->where('status', 'accepted')->count())
                ->description('Approved submissions')
                ->color('success'),

            
            Stat::make('Pending Papers', (string) $pendingReviews)
                ->description('Papers awaiting review')
                ->color('warning'),


            Stat::make('Under Review Papers', (string) $underReviewReviews)
                ->description('Papers currently under review')
                ->color('warning'),

            Stat::make('Rejected Papers', (string) $rejectedReviews)
                ->description('Submissions that were rejected')
                ->color('danger'),
        ];
    }
}
