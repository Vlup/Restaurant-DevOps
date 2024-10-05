<?php

namespace App\Providers;

// use App\Providers\Passport;
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
        // Passport::loadKeysFrom(__DIR__.'/../secrets/oauth');
    }
}
