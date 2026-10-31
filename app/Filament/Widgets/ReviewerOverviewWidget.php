<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReviewerOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $reviews = Review::query()->where('reviewer_id', auth()->id());

        return [
            Stat::make('Assigned reviews', (string) (clone $reviews)->count())
                ->description('Total papers assigned to you')
                ->color('primary'),
            Stat::make('Pending reviews', (string) (clone $reviews)->where('status', 'pending')->count())
                ->description('Awaiting your evaluation')
                ->color('warning'),
            Stat::make('Completed reviews', (string) (clone $reviews)->where('status', '!=', 'pending')->count())
                ->description('Reviews submitted')
                ->color('success'),
            Stat::make('Recommend acceptance', (string) (clone $reviews)->where('status', 'accepted')->count())
                ->description('Your acceptance recommendations')
                ->color('success'),
            Stat::make('Recommend rejection', (string) (clone $reviews)->where('status', 'rejected')->count())
                ->description('Your rejection recommendations')
                ->color('danger'),
            Stat::make('Revision required', (string) (clone $reviews)->where('status', 'revision_required')->count())
                ->description('Your revision recommendations')
                ->color('warning'),
        ];
    }
}
