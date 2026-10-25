<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\PreventPromptInjection;
use Illuminate\Http\Middleware\ThrottleRequests;

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
        $this->registerRouteMiddleware();
    }

    /**
     * Register custom route middleware.
     */
    protected function registerRouteMiddleware(): void
    {
        $router = $this->app['router'];

        $router->aliasMiddleware('prompt.injection', PreventPromptInjection::class);
    }
}