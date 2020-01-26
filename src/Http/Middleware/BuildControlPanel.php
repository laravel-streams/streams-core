<?php

namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Closure;
use Illuminate\Http\Request;

/**
 * Class BuildControlPanel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildControlPanel
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
        app(ControlPanelBuilder::class)->build();

        return $next($request);
    }
}
