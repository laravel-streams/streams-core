<?php

namespace Anomaly\Streams\Platform\Provider\Concerns;

use Illuminate\Support\Facades\Route;

/**
 * Trait RegistersMiddleware
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait RegistersMiddleware
{

    /**
     * The middleware by group.
     *
     * @var array
     */
    public $middleware = [];

    /**
     * Register middleware by group.
     */
    protected function registerMiddleware()
    {
        foreach ($this->middleware as $group => $middlewares) {
            foreach ($middlewares as $middleware) {
                Route::pushMiddlewareToGroup($group, $middleware);
            }
        }
    }
}
