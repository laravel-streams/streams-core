<?php namespace Streams\Core\Provider;

use Illuminate\Routing\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for core.
     *
     * @return void
     */
    public function map()
    {
        \App::booted(
            function () {

                // Once the application has booted, we will include the core routes
                // file. This "namespace" helper will load the routes file within a
                // route group which automatically sets the controller namespace.

                include __DIR__ . '/../Http/routes.php';
            }
        );
    }
}
