<?php namespace Anomaly\Streams\Platform\Provider;

use Illuminate\Routing\Router;

/**
 * Class RouteServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Provider
 */
class RouteServiceProvider extends \Illuminate\Foundation\Support\Providers\RouteServiceProvider
{

    /**
     * All of the application's route middleware keys.
     * These have to be provided by the platform itself
     * or provided in an addon.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * Called before routes are registered.
     * Register any model bindings or pattern based filters.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function before(Router $router)
    {
        if (app('request')->isMethod('post')) {
            //'Anomaly\Streams\Platform\Http\Middleware\CheckCsrfToken'
        }
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

    /**
     * Route a bunch of routes.
     *
     * @param Router $router
     * @param array  $routes
     */
    protected function route(Router $router, array $routes)
    {
        $prefix = $this->guessControllerNamespace();

        foreach ($routes as $route => $action) {

            if (is_string($action) and !starts_with($action, 'Anomaly')) {

                $action = $prefix . $action;
            }

            if (starts_with($route, 'any::')) {

                $router->any(substr($route, 5), $action);
            }

            if (starts_with($route, 'get::')) {

                $router->get(substr($route, 5), $action);
            }

            if (starts_with($route, 'post::')) {

                $router->post(substr($route, 6), $action);
            }
        }
    }

    /**
     * Guess the base namespace.
     *
     * @return string
     */
    protected function guessBaseNamespace()
    {
        $namespace = explode('\\', get_class($this));

        return implode('\\', array_slice($namespace, 0, -2));
    }

    /**
     * Guess the controller namespace.
     *
     * @return string
     */
    private function guessControllerNamespace()
    {
        $base = $this->guessBaseNamespace();

        return $base . '\Http\Controller\\';
    }
}
 