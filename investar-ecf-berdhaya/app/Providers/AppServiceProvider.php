<?php

namespace App\Providers;

use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // condition 1
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // condition 2
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        // condition 3
        if (env('APP_FORCE_HTTPS', false)) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }
        //
        DB::connection('mongodb')->enableQueryLog();
        DB::connection('mongodb')->listen(function ($sql) {
            //Log::info($sql . var_export($bindings, true));
            Log::info($sql->sql);
            Log::info($sql->bindings);
            Log::info($sql->time);
        });

        Queue::after(function (JobProcessed $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
        });
    }
}
