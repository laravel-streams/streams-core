<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProxySession
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ProxySession
{

    /**
     * Push the user check state to cookie
     * so that the services like HTTPCACHE
     * can keep up with activity within the
     * CMS which is generally bypassed early.
     *
     * @param Request $request
     * @param Closure $next
     * @return bool|\Illuminate\Http\RedirectResponse|mixed|string
     */
    public function handle(Request $request, Closure $next)
    {
        $check = auth()->check();

        $response = $next($request);

        if ($response instanceof Response) {
            return $response->withCookie(
                cookie('session_proxy', $check, $check ? config('session.lifetime', 120) : -1)
            );
        }

        return $response;
    }
}
