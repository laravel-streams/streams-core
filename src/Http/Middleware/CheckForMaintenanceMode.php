<?php

namespace Anomaly\Streams\Platform\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class CheckForMaintenanceMode.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class CheckForMaintenanceMode
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * Create a new CheckForMaintenanceMode instance.
     *
     * @param  Application $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance()) {
            abort(503);
        }

        return $next($request);
    }
}
