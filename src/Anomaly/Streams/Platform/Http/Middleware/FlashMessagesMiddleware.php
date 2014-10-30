<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Illuminate\Contracts\Routing\Middleware;

class FlashMessagesMiddleware implements Middleware
{

    public function handle($request, \Closure $next)
    {
        app('streams.messages')->merge(app('session')->get('messages', []));

        return $next($request);
    }
}
 