<?php

namespace SamuelNitsche\LaravelPayrexx;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Payrexx\Payrexx;

class PayrexxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->registerPayrexx();
        $this->registerPublishing();
        $this->registerMigrations();
        $this->registerRoutes();

        /*
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'payrexx');


        */
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->configure();
    }

    protected function registerPayrexx(): void
    {
        $this->app->singleton('payrexx', function ($app) {
            return new Payrexx(config('payrexx.instance_name'), config('payrexx.api_secret'));
        });
    }

    protected function configure(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'payrexx');
    }

    public function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('config.php'),
            ], 'config');

            // $this->publishes([
            //      __DIR__.'/../resources/views' => base_path('resources/views/vendor/payrexx'),
            // ], 'views');
        }
    }

    public function registerMigrations(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }
    }

    protected function registerRoutes()
    {
        Route::group([
            'prefix' => config('payrexx.path', 'payrexx'),
            'namespace' => 'SamuelNitsche\LaravelPayrexx\Http\Controllers',
            'as' => 'payrexx.',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }
}
