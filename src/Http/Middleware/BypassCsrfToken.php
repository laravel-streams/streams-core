<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class BypassCsrfToken
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class BypassCsrfToken
{

    /**
     * Handle the request.
     *
     * Bypass the Laravel CSRF protection
     * in it's default position - we will be
     * checking it later JUST after the route
     * has been resolved.
     *
     * @param Request  $request
     * @param callable $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
