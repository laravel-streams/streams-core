<?php

namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\Streams\Platform\Support\Facades\Locator;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

/**
 * Class DetectActiveModule
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DetectActiveModule
{

    /**
     * Force SSL connections.
     *
     * @param  Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        /**
         * In order to detect we MUST have a route
         * and we MUST have a namespace in the
         * streams::addon action parameter.
         *
         * @var Route $route
         */
        if (!$route = $request->route()) {
            return $next($request);
        }

        if (!$controller = $route->getController()) {
            return $next($request);
        }

        if (!$detected = Locator::locate(get_class($controller))) {
            return $next($request);
        }

        app('module.collection')->setActive($detected);

        return $next($request);
    }
}
