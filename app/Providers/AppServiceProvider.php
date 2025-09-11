<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
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
        Carbon::macro('inApplicationTimezone', fn () => $this->tz((string) (config('app.timezone_display', 'UTC'))));

        Carbon::macro('inUserTimezone', fn () => $this->tz(auth()->user()->timezone ?? (string) (config('app.timezone_display', 'UTC'))));
    }
}
