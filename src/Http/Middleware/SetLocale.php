<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

/**
 * Class SetLocale
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class SetLocale
{

    /**
     * The redirect utility.
     *
     * @var Redirector
     */
    protected $redirect;

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $repository;

    /**
     * The laravel application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new SetLocale instance.
     *
     * @param Redirector  $redirect
     * @param Repository  $repository
     * @param Application $application
     */
    public function __construct(Redirector $redirect, Repository $repository, Application $application)
    {
        $this->redirect    = $redirect;
        $this->repository  = $repository;
        $this->application = $application;
    }

    /**
     * Look for locale=LOCALE in the query string.
     *
     * @param  Request  $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (defined('LOCALE')) {
            return $next($request);
        }

        if ($locale = $request->get('_locale')) {

            if ($locale) {
                $request->session()->put('_locale', $locale);
            } else {
                $request->session()->remove('_locale');
            }

            return $this->redirect->to($request->path());
        }

        if ($locale = $request->session()->get('_locale')) {

            $this->application->setLocale($locale);

            $this->repository->set('_locale', $locale);
        }

        return $next($request);
    }
}
