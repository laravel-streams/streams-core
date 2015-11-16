<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Session\Store;
use Symfony\Component\HttpFoundation\Response;

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
        if ($locale = $request->get('locale')) {

            if ($locale) {
                $request->session()->put('locale', $locale);
            } else {
                $request->session()->remove('locale');
            }

            return $this->redirect->to($request->path());
        }

        if ($locale = $request->session()->get('locale')) {

            $this->application->setLocale($locale);

            $this->repository->set('locale', $locale);
        }

        return $next($request);
    }
}
