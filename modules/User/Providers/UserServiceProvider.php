<?php

declare(strict_types=1);

namespace Modules\User\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\User\Contracts\UserRepositoryInterface;
use Modules\User\Events\UserCreated;
use Modules\User\Listeners\HandleUserCreated;
use Modules\User\Repositories\UserRepository;
use Modules\User\Services\UserCreationService;

final class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(UserCreationService::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__.'/../config.php', 'user');

        $this->app->register(RouteServiceProvider::class);

        $this->loadViewsFrom(__DIR__.'/../views', 'user');

        $this->registerLivewireComponents();
        $this->registerEventListeners();
    }

    protected function registerLivewireComponents(): void
    {
        Livewire::component('user.index', \Modules\User\Livewire\Index::class);
        Livewire::component('user.create', \Modules\User\Livewire\Create::class);
    }

    protected function registerEventListeners(): void
    {
        Event::listen(
            UserCreated::class,
            [HandleUserCreated::class, 'handle']
        );
    }
}
