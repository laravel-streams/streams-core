<?php

namespace Anomaly\Streams\Platform\Addon\Workflow;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Illuminate\Contracts\Container\Container;

/**
 * Class RegisterApi
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class RegisterApi
{

    /**
     * Handle registering the addon's API.
     *
     * @param AddonServiceProvider $provider
     * @param Container $app
     */
    public function handle(AddonServiceProvider $provider, Container $app)
    {

        /**
         * Skip if there is nothing to do.
         */
        if (!$provider->api || $app->routesAreCached()) {
            return;
        }

        /**
         * Loop over the routes and normalize
         */
        $provider->router->group(
            [
                'middleware' => 'auth:api',
            ],
            function () use ($provider) {
                foreach ($provider->api as $uri => $route) {

                    /*
                     * If the route definition is an
                     * not an array then let's make it one.
                     * Array type routes give us more control
                     * and allow us to pass information in the
                     * request's route action array.
                     */
                    if (!is_array($route)) {
                        $route = [
                            'uses' => $route,
                        ];
                    }

                    $verb        = array_pull($route, 'verb', 'any');
                    $middleware  = array_pull($route, 'middleware', []);
                    $constraints = array_pull($route, 'constraints', []);

                    if (is_string($route['uses']) && !str_contains($route['uses'], '@')) {
                        \Route::resource($uri, $route['uses']);
                    } else {
                        $route = \Route::{$verb}($uri, $route)->where($constraints);

                        if ($middleware) {
                            call_user_func_array([$route, 'middleware'], (array) $middleware);
                        }
                    }
                }
            }
        );
    }
}
