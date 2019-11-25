<?php

namespace SamuelNitsche\LaravelPayrexx;

use Illuminate\Support\ServiceProvider;
use Payrexx\Payrexx;

class PayrexxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->singleton('payrexx', function ($app) {
            return new Payrexx(config('payrexx.instance_name'), config('payrexx.api_secret'));
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('config.php'),
            ], 'config');

            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

            /*
            $this->loadViewsFrom(__DIR__.'/../resources/views', 'payrexx');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/payrexx'),
            ], 'views');
            */
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'payrexx');
    }
}
