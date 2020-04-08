<?php

namespace Anomaly\Streams\Platform\Addon\Workflow;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Stream\StreamRegistry;
use Illuminate\Contracts\Container\Container;

/**
 * Class RegisterMiddleware
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class RegisterMiddleware
{

    /**
     * Handle registering the addon's Streams.
     *
     * @param AddonServiceProvider $provider
     * @param Container $app
     * @param string $namespace
     */
    public function handle(AddonServiceProvider $provider)
    {
        foreach ($provider->middleware as $group => $middlewares) {
            foreach ($middlewares as $middleware) {
                \Route::pushMiddlewareToGroup($group, $middleware);
            }
        }
    }
}
