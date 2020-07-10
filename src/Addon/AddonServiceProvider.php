<?php

namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Provider\ServiceProvider;

/**
 * Class AddonServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonServiceProvider extends ServiceProvider
{

    /**
     * Register directory routes.
     */
    protected function afterRegisterRoutes()
    {
        foreach (array_keys($this->routes) as $group) {
            if (file_exists($routes = __DIR__ . '/')) {
                require_once $routes;
            }
        }
    }
}
