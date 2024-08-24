<?php

namespace App\Providers;

use App\Models\Cohort;
use App\Observers\CohortObserver;
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
        Cohort::observe(CohortObserver::class);
    }
}
