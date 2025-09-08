<?php

namespace Laracasts\Flash;

use Illuminate\Support\ServiceProvider;

class FlashServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton('flash', function ($app) {
            return new FlashNotifier($app['session']);
        });
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(resource_path('views/vendor/flash'), 'flash');
    }
}
