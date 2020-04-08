<?php

namespace Anomaly\Streams\Platform\Addon\Workflow;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Illuminate\Contracts\Container\Container;

/**
 * Class RegisterRoutes
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class RegisterRoutes
{

    /**
     * Handle registering the addon's routes.
     *
     * @param AddonServiceProvider $provider
     * @param Container $app
     */
    public function handle(AddonServiceProvider $provider, Container $app)
    {

        /**
         * Skip if there is nothing to do.
         */
        if (!$provider->routes || $app->routesAreCached()) {
            return;
        }

        /**
         * Loop over the routes and normalize
         */
        foreach ($provider->routes as $uri => $route) {

            /*
             * If the route definition is an
             * not an array then let's make it one.
             * Array type routes give us more control
             * and allow us to pass information in the
             * request's route action array.
             */
            if (!is_array($route) && str_contains($route, ['::', '.'])) {
                $provider->router->view($uri, $route);
            }

            if (!is_array($route)) {
                $route = [
                    'uses' => $route,
                ];
            }

            $verb = array_pull($route, 'verb', 'any');

            $group       = array_pull($route, 'group', []);
            $middleware  = array_pull($route, 'middleware', ['web']);
            $constraints = array_pull($route, 'constraints', []);

            if (is_string($route['uses']) && !str_contains($route['uses'], '@')) {
                \Route::middleware('web')->group(function () use ($uri, $route) {
                    \Route::resource($uri, $route['uses']);
                });
            } else {
                \Route::middleware('web')->group(function () use ($uri, $verb, $route, $group, $middleware, $constraints) {

                    $route = \Route::{$verb}($uri, $route)->where($constraints);

                    if ($middleware) {
                        call_user_func_array([$route, 'middleware'], (array) $middleware);
                    }

                    if ($group) {
                        call_user_func_array([$route, 'group'], (array) $group);
                    }
                });
            }
        }
    }
}
