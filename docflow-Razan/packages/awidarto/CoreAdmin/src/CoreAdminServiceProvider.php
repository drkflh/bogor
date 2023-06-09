<?php

namespace awidarto\CoreAdmin;

use Illuminate\Support\ServiceProvider;

class CoreAdminServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'awidarto');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'awidarto');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/coreadmin.php', 'coreadmin');

        // Register the service the package provides.
        $this->app->singleton('coreadmin', function ($app) {
            return new CoreAdmin;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['coreadmin'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/coreadmin.php' => config_path('coreadmin.php'),
        ], 'coreadmin.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/awidarto'),
        ], 'coreadmin.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/awidarto'),
        ], 'coreadmin.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/awidarto'),
        ], 'coreadmin.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
