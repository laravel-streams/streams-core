<?php

namespace Anomaly\Streams\Platform\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Auth\Guard;
use Symfony\Component\HttpFoundation\IpUtils;
use Anomaly\Streams\Platform\Support\Authorizer;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Foundation\Application as Laravel;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;

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
     * @param Laravel $app
     * @param Guard $guard
     * @param Authorizer $authorizer
     * @param Application $application
     */
    public function __construct(
        Laravel $app,
        Guard $guard,
        Authorizer $authorizer,
        Application $application
    ) {
        $this->app         = $app;
        $this->guard       = $guard;
        $this->authorizer  = $authorizer;
        $this->application = $application;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return void|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->application->isEnabled()) {
            abort(503);
        }

        if (
            !$this->app->isDownForMaintenance() &&
            !config('streams::maintenance.enabled', false)
        ) {
            return $next($request);
        }

        if ($request->segment(1) == 'admin' || str_is('form/handle/*', $request->path())) {
            return $next($request);
        }

        if (in_array($request->getClientIp(), config('streams::maintenance.ip_whitelist', []))) {
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

        if (!$user && config('streams::maintenance.auth')) {

            /* @var Response|null $response */
            $response = $this->guard->onceBasic();

            if (!$response) {
                return $next($request);
            }

            $response->setContent(view('streams::errors.401'));

            return $response;
        }

        $data = json_decode(file_get_contents($this->app->storagePath() . '/framework/down'), true);

        if (isset($data['allowed']) && IpUtils::checkIp($request->ip(), (array) $data['allowed'])) {
            return $next($request);
        }

        throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
    }
}
