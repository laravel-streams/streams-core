<?php namespace Anomaly\Streams\Platform\Provider;

class RouteServiceProvider extends \Illuminate\Foundation\Support\Providers\RouteServiceProvider
{
    protected $middleware = [];

    /**
     * Run before the app is booted.
     */
    public function before()
    {
    }

    /**
     * Define the routes for core.
     */
    public function map()
    {
        // Once the application has booted, we will include the core routes
        // file. This "namespace" helper will load the routes file within a
        // route group which automatically sets the controller namespace.
        include __DIR__ . '/../../../../../resources/routes.php';
    }
}
