<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(function($router){
                 require base_path('routes/web.php');
                 require base_path('routes/app/common.php');

                 $suite = explode('|', env('APP_ROUTE_SUITE', '') );

                 info('SUITE ROUTE', $suite);

                 if(env('APP_ROUTE_FILE') == 'suite' && is_array($suite)){
                    foreach($suite as $app){
                        require base_path('routes/app/'.$app.'.php');
                    }
                 }else{
                     if(env('APP_ROUTE_FILE') != ''){
                         require base_path(env('APP_ROUTE_FILE'));
                     }
                 }
             });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group( function ($router){
                 require base_path('routes/api.php');
                 require base_path('routes/api/common.php');
                 require base_path(env('APP_API_ROUTE_FILE'));
             });
    }
}
