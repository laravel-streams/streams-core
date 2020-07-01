<?php

namespace Anomaly\Streams\Platform\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Anomaly\Streams\Platform\Support\Facades\Locator;

/**
 * Class DetectAddon
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DetectAddon
{

    /**
     * Force SSL connections.
     *
     * @param  Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {

        if (!$route = $request->route()) {
            return $next($request);
        }

        if (!$controller = $route->getController()) {
            return $next($request);
        }

        if (!$detected = Locator::locate(get_class($controller))) {
            return $next($request);
        }

        app('streams.addons')->setActive($detected);

        return $next($request);
    }
}
