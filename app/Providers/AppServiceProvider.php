<?php

namespace App\Providers;

use App\Models\Absence;
use Illuminate\Support\ServiceProvider;
use App\Observers\AbsenceObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Absence::observe(AbsenceObserver::class);
    }
}
