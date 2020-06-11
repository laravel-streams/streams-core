<?php

namespace Anomaly\Streams\Platform\Provider\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

/**
 * Trait RegistersRoutes
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait RegistersRoutes
{

    /**
     * The provider routes.
     *
     * @var array
     */
    public $routes = [];

    /**
     * Undocumented function
     **/
    protected function registerRoutes()
    {
        if (!$this->routes || $this->app->routesAreCached()) {
            return;
        }

        /**
         * Normalize the routes.
         */
        $routes = $this->routes();

        Route::middleware('web')->group(function () use ($routes) {
            $this->route($routes->filter(function ($route) {
                return !$route['admin'];
            })->all());
        });

        Route::prefix(config('streams.cp.prefix', 'admin'))
            ->middleware([
                'web',
            ]) // @todo replace this with 'cp'
            ->group(function () use ($routes) {
                $this->route($routes->filter(function ($route) {
                    return $route['admin'];
                })->all());
            });
    }

    /**
     * Return normalized routes.
     * 
     * @return Collection
     */
    protected function routes()
    {
        return collect($this->routes)->transform(function ($route, $uri) {

            if (is_string($route)) {
                $route = [
                    strpos($route, '::') ? 'view' : 'uses' => $route,
                ];
            }

            $route['uri'] = ltrim($uri, '/');
            $route['admin'] = Str::startsWith($route['uri'], 'admin');

            if ($route['admin']) {
                $route['uri'] = ltrim(str_replace_first('admin', '', $route['uri']), '/');
            }

            return $route;
        });
    }

    /**
     * Route the provided routes.
     *
     * @param array $routes
     */
    protected function route(array $routes)
    {
        foreach ($routes as $route) {

            /**
             * Pull out post-route configuration. 
             */
            $verb        = Arr::pull($route, 'verb', 'any');
            $middleware  = Arr::pull($route, 'middleware', []);
            $constraints = Arr::pull($route, 'constraints', []);

            /**
             * If the route defines
             * a view then use that.
             * -----------------------
             * If the route contains a
             * controller@action then 
             * create a normal route.
             * -----------------------
             * If the route does NOT
             * contain an action then
             * treat it as a resource.
             */
            if (isset($route['view'])) {
                $route = Route::view($route['uri'], $route['view']);
            } elseif (Str::contains($route['uses'], '@')) {
                $route = Route::{$verb}($route['uri'], $route);
            } else {
                $route = Route::resource($route['uri'], $route['uses']);
            }

            /**
             * Call constraints if
             * any are provided.
             */
            if ($constraints) {
                call_user_func_array([$route, 'constraints'], (array) $constraints);
            }

            /**
             * Call middleware if
             * any are provided.
             */
            if ($middleware) {
                call_user_func_array([$route, 'middleware'], (array) $middleware);
            }
        }
    }
}
