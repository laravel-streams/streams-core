<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Support\Authorizer;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application as Laravel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class CheckForMaintenanceMode
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CheckForMaintenanceMode
{

    /**
     * The application instance.
     *
     * @var Laravel
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
     * The application instance.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new CheckForMaintenanceMode instance.
     *
     * @param Laravel     $app
     * @param Guard       $guard
     * @param Repository  $config
     * @param Authorizer  $authorizer
     * @param Application $application
     */
    public function __construct(
        Laravel $app,
        Guard $guard,
        Repository $config,
        Authorizer $authorizer,
        Application $application
    ) {
        $this->app         = $app;
        $this->guard       = $guard;
        $this->config      = $config;
        $this->authorizer  = $authorizer;
        $this->application = $application;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return void|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->application->isEnabled()) {
            abort(503);
        }

        if (!$this->app->isDownForMaintenance()) {
            return $next($request);
        }

        if ($request->segment(1) == 'admin' || str_is('form/handle/*', $request->path())) {
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

        if (!$user && $this->config->get('streams::maintenance.auth')) {

            /* @var Response|null $response */
            $response = $this->guard->onceBasic();

            if (!$response) {
                return $next($request);
            }

            $response->setContent(view('streams::errors.401'));

            return $response;
        }

        abort(503);
    }
}
