<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\Streams\Platform\Support\Authorizer;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

/**
 * Class CheckForMaintenanceMode
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
     * The auth guard.
     *
     * @var Guard
     */
    protected $guard;

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The permission authorizer.
     *
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * Create a new CheckForMaintenanceMode instance.
     *
     * @param  Application $app
     * @param Guard        $guard
     * @param Repository   $config
     * @param Authorizer   $authorizer
     */
    public function __construct(Application $app, Guard $guard, Repository $config, Authorizer $authorizer)
    {
        $this->app        = $app;
        $this->guard      = $guard;
        $this->config     = $config;
        $this->authorizer = $authorizer;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->app->isDownForMaintenance()) {
            return $next($request);
        }

        if ($request->segment(1) == 'admin') {
            return $next($request);
        }

        if (in_array($request->getClientIp(), $this->config->get('streams::maintenance.ip_whitelist', []))) {
            return $next($request);
        }

        /* @var UserInterface $user */
        $user = $this->guard->user();

        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        if ($user && $this->authorizer->authorize('streams::maintenance.access')) {
            return $next($request);
        }

        if (!$user) {
            return $this->guard->onceBasic() ?: $next($request);
        }

        abort(503);
    }
}
