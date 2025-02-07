<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\ExternalAPIConsumerServiceInterface;
use App\Services\Implementations\ExternalAPIConsumerService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ExternalAPIConsumerServiceInterface::class, ExternalAPIConsumerService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
