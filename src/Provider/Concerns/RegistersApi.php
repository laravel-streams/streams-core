<?php

namespace Anomaly\Streams\Platform\Provider\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/**
 * Trait RegistersApi
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait RegistersApi
{

    /**
     * The API routes.
     *
     * @var array
     */
    public $api = [];

    /**
     * Register the API routes.
     */
    protected function registerApi()
    {
        if (!$this->api || App::routesAreCached()) {
            return;
        }

        Route::middleware('api')->group(function () {

            foreach ($this->api as $uri => $route) {

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
                if (Str::contains($route['uses'], '@')) {
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
