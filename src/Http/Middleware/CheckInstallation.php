<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

/**
 * Class CheckInstallation
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class CheckInstallation implements Middleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @return Redirector
     */
    public function handle($request, \Closure $next)
    {
        if ($request->segment(1) !== 'installer' and !app('streams.application')->isInstalled()) {

            return redirect('installer');
        }

        return $next($request);
    }
}
