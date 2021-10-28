<?php

namespace Nour\Filter;

use Illuminate\Support\ServiceProvider;
use Nour\Filter\Facades\Filter;

class FilterServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/filter.php', 'filter');

        // Register the service the package provides.
        $this->app->singleton('filter', function ($app) {
            return new Filter();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['filter'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {

        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/filter.php' => config_path('filter.php'),
        ], 'filter.config');

    }
}
