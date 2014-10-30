<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Illuminate\Http\Request;

class LocaleMiddleware
{

    /**
     * Setup the application.
     *
     * @param Request $request
     */
    public function handle(Request $request, \Closure $next)
    {
        $auth        = app('auth');
        $config      = app('config');
        $session     = app('session');
        $application = app('streams.application');

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
