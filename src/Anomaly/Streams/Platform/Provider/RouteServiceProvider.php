<?php namespace Anomaly\Streams\Platform\Provider;

use Illuminate\Routing\Router;

class RouteServiceProvider extends \Illuminate\Foundation\Support\Providers\RouteServiceProvider
{
    /**
     * All of the application's route middleware keys.
     * These have to be provided by the platform itself
     * or provided in an addon.
     *
     * @var array
     */
    protected $middleware = [
        'auth' => 'App\Http\Middleware\Authenticated',
    ];

    /**
     * Called before routes are registered.
     * Register any model bindings or pattern based filters.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function before(Router $router)
    {
        //
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        //
    }
}
 