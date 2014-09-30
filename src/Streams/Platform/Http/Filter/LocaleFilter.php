<?php namespace Streams\Platform\Http\Filter;

class LocaleFilter
{
    /**
     * Set the application locale.
     *
     * @return mixed
     */
    public function filter()
    {
        $auth        = app()->make('auth');
        $config      = app()->make('config');
        $session     = app()->make('session');
        $request     = app()->make('request');
        $application = app()->make('streams.application');

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
    }
}
