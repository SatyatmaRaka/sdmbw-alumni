<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Alumni;
use App\Models\AlumniPendidikan;
use App\Models\AlumniPekerjaan;
use App\Policies\AlumniPolicy;
use App\Observers\AlumniCompletenessObserver;

use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();

        Gate::policy(Alumni::class, AlumniPolicy::class);
        Gate::policy(AlumniPendidikan::class, AlumniPolicy::class);
        Gate::policy(AlumniPekerjaan::class, AlumniPolicy::class);

        // Observers for Data Sync
        Alumni::observe(AlumniCompletenessObserver::class);
        AlumniPendidikan::observe(AlumniCompletenessObserver::class);
        AlumniPekerjaan::observe(AlumniCompletenessObserver::class);
    }
}
