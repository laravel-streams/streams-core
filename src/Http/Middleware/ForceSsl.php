<?php

namespace Anomaly\Streams\Platform\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;

/**
 * Class ForceSsl
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ForceSsl
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
        $force = Config::get('streams.system.force_ssl', false);

        if ($force && !$request->isSecure()) {
            return Response::secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
