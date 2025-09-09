<?php

declare(strict_types=1);

namespace App\Domains\User\Providers;

use App\Domains\User\Contracts\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

final class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class,
        );
    }
}
