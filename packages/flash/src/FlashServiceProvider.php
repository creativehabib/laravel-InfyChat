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
            // The session binding resolves to the session manager which does not
            // satisfy the type-hint of the flash notifier. Resolve the actual
            // session store implementation instead.
            return new FlashNotifier($app['session.store']);
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
