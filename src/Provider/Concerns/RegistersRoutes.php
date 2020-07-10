<?php

namespace Anomaly\Streams\Platform\Provider\Concerns;

use Illuminate\Support\Arr;
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
     * Register the addon routes.
     */
    protected function registerRoutes()
    {
        foreach ($this->routes as $group => $routes) {
            Route::middleware($group)->group(function () use ($routes) {
                foreach ($routes as $uri => $route) {
    
                    /*
                     * Normalize the route
                     * into an array as needed.
                     */
                    if (is_string($route)) {
                        $route = [
                            'uses' => $route,
                        ];
                    }
    
                    /**
                     * Pull out post-route configuration. 
                     */
                    $verb        = Arr::pull($route, 'verb', 'any');
                    $middleware  = Arr::pull($route, 'middleware', []);
                    $constraints = Arr::pull($route, 'constraints', []);
    
                    /**
                     * If the route contains a
                     * controller@action then 
                     * create a normal route.
                     * -----------------------
                     * If the route does NOT
                     * contain an action then
                     * treat it as a resource.
                     */
                    if (str_contains($route['uses'], '@')) {
                        $route = Route::{$verb}($uri, $route);
                    } else {
                        $route = Route::resource($uri, $route['uses']);
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
            });
        }
    }
}
