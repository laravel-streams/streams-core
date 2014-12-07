<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Http\Request;

/**
 * Class SetLocale
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class SetLocale implements Middleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     */
    public function handle($request, \Closure $next)
    {
        $config      = app('config');
        $session     = app('session');
        $auth        = app('streams.auth');
        $application = app('streams.application');

        return $next($request); // TODO: This is fucked up.

        // If the application is installed try getting
        // and storing the locale on the user. If the
        // user is not logged in - use the session.

        // If the application is NOT installed then
        // work with the session locale.

        if ($locale = $request->get('locale')) {

            if ($application->isInstalled() and $auth->check()) {

                $auth->getUser()->changeLocale($locale);
            } else {

                $session->set('locale', $locale);
            }
        }

        if ($application->isInstalled() and $auth->check()) {

            $locale = $auth->getUser()->getLocale($config->get('locale'));
        } else {

            $locale = $session->get('locale', $config->get('locale'));
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
