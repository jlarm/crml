<?php

namespace Modules\Dealership\Providers;



use Illuminate\Support\ServiceProvider;

final class DealershipServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'dealership');

        $this->loadViewsFrom(__DIR__ . '/../views', 'dealership');
    }
}
