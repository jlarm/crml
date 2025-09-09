<?php

declare(strict_types=1);

namespace Modules\User\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

final class UserServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__.'/../config.php', 'user');

        $this->app->register(RouteServiceProvider::class);

        $this->loadViewsFrom(__DIR__.'/../views', 'user');

        // Register Livewire components
        $this->registerLivewireComponents();
    }

    protected function registerLivewireComponents(): void
    {
        Livewire::component('user.index', \Modules\User\Livewire\Index::class);
    }
}
