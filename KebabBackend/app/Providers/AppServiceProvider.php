<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\KebabService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(KebabService::class, function ($app) {
            return new KebabService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
