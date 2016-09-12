<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Anomaly\Streams\Platform\Application\Application as Application2;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Class SetLocale
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class SetLocale
{

    /**
     * The config config.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The redirect utility.
     *
     * @var Redirector
     */
    protected $redirect;

    /**
     * The laravel application.
     *
     * @var Application
     */
    protected $application;

    /**
     * The laravel application.
     *
     * @var files
     */
    protected $files;

    /**
     * Create a new SetLocale instance.
     *
     * @param Repository  $config
     * @param Redirector  $redirect
     * @param Application $application
     */
    public function __construct(Repository $config, Redirector $redirect, Application $application, Application2 $application2,Filesystem $files)
    {
        $this->config      = $config;
        $this->redirect    = $redirect;
        $this->application = $application;
        $this->application2 = $application2;
        $this->files       = $files;
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
                $this->files->deleteDirectory($this->application2->getAssetsPath('assets'), true);
            } else {
                $request->session()->remove('_locale');
            }

            return $this->redirect->to($request->path());
        }

        if ($locale = $request->session()->get('_locale')) {
            $this->application->setLocale($locale);

            $this->config->set('_locale', $locale);
        }

        if (!$locale) {
            $this->application->setLocale($this->config->get('streams::locales.default'));
        }

        return $next($request);
    }
}
