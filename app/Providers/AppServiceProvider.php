<?php

namespace App\Providers;

use App\Models\PartnerLogo;
use App\Models\Review;
use App\Observers\ReviewObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        config([
            'livewire.temporary_file_upload.rules' => ['required', 'file', 'max:16384'],
        ]);

        Review::observe(ReviewObserver::class);

        View::composer('layouts.partials.header', function ($view): void {
            $view->with(
                'partnerLogos',
                PartnerLogo::query()
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->get(),
            );
        });
    }
}
