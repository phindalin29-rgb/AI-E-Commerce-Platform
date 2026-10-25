<?php

namespace Webkul\AI\Providers;

use Illuminate\Support\ServiceProvider;

class AIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerConfig();
        $this->registerServices();
        $this->registerRoutes();
        $this->registerMigrations();
        $this->registerTranslations();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'ai');
    }

    /**
     * Register package config.
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/config.php',
            'ai'
        );
    }

    /**
     * Register AI services as singletons.
     */
    protected function registerServices(): void
    {
        $this->app->singleton(
            \Webkul\AI\Services\AI\RecommendationService::class,
            \Webkul\AI\Services\AI\RecommendationService::class
        );

        $this->app->singleton(
            \Webkul\AI\Services\AI\ChatbotService::class,
            \Webkul\AI\Services\AI\ChatbotService::class
        );

        $this->app->singleton(
            \Webkul\AI\Services\AI\SmartSearchService::class,
            \Webkul\AI\Services\AI\SmartSearchService::class
        );

        $this->app->singleton(
            \Webkul\AI\Services\AI\InsightService::class,
            \Webkul\AI\Services\AI\InsightService::class
        );
    }

    /**
     * Register routes.
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
    }

    /**
     * Register migrations.
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    /**
     * Register translations.
     */
    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'ai');
    }
}