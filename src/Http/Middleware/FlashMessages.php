<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Illuminate\Contracts\Routing\Middleware;

/**
 * Class FlashMessages
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class FlashMessages implements Middleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param callable                 $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        app('streams.messages')->merge(app('session')->get('messages', []));

        return $next($request);
    }
}
 