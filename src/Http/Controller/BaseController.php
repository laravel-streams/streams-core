<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Anomaly\Streams\Platform\Event\Response;
use Anomaly\Streams\Platform\Http\Middleware\ApplicationReady;
use Anomaly\Streams\Platform\Http\Middleware\CheckLocale;
use Anomaly\Streams\Platform\Http\Middleware\ForceSsl;
use Anomaly\Streams\Platform\Http\Middleware\HttpCache;
use Anomaly\Streams\Platform\Http\Middleware\MiddlewareCollection;
use Anomaly\Streams\Platform\Http\Middleware\PoweredBy;
use Anomaly\Streams\Platform\Http\Middleware\PrefixDomain;
use Anomaly\Streams\Platform\Http\Middleware\SetLocale;
use Anomaly\Streams\Platform\Http\Middleware\VerifyCsrfToken;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;

/**
 * Class BaseController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BaseController extends Controller
{

    use DispatchesJobs;
    use FiresCallbacks;

    /**
     * The service container.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * The URL generator.
     *
     * @var \Anomaly\Streams\Platform\Routing\UrlGenerator
     */
    protected $url;

    /**
     * The view factory.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $view;

    /**
     * The asset manager.
     *
     * @var \Anomaly\Streams\Platform\Asset\Asset
     */
    protected $asset;

    /**
     * The route object.
     *
     * @var \Illuminate\Routing\Route
     */
    protected $route;

    /**
     * The event dispatcher.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * The request object.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The flash messages.
     *
     * @var \Anomaly\Streams\Platform\Message\MessageBag
     */
    protected $messages;

    /**
     * The redirect utility.
     *
     * @var \Illuminate\Routing\Redirector
     */
    protected $redirect;

    /**
     * The view template.
     *
     * @var \Anomaly\Streams\Platform\View\ViewTemplate
     */
    protected $template;

    /**
     * The response factory.
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * The breadcrumb collection.
     *
     * @var \Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection
     */
    protected $breadcrumbs;

    /**
     * Create a new BaseController instance.
     */
    public function __construct()
    {
        $this->container   = app();
        $this->request     = app('Illuminate\Http\Request');
        $this->redirect    = app('Illuminate\Routing\Redirector');
        $this->view        = app('Illuminate\Contracts\View\Factory');
        $this->asset       = app('Anomaly\Streams\Platform\Asset\Asset');
        $this->events      = app('Illuminate\Contracts\Events\Dispatcher');
        $this->template    = app('Anomaly\Streams\Platform\View\ViewTemplate');
        $this->messages    = app('Anomaly\Streams\Platform\Message\MessageBag');
        $this->response    = app('Illuminate\Contracts\Routing\ResponseFactory');
        $this->url         = app('Anomaly\Streams\Platform\Routing\UrlGenerator');
        $this->breadcrumbs = app('Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection');

        $this->route = $this->request->route();

        $this->middleware(VerifyCsrfToken::class);

        $this->events->dispatch(new Response($this));

        $this->middleware(PoweredBy::class);

        $this->middleware(ForceSsl::class);
        $this->middleware(PrefixDomain::class);

        $this->middleware(SetLocale::class);
        $this->middleware(CheckLocale::class);
        $this->middleware(ApplicationReady::class);

        foreach (app(MiddlewareCollection::class) as $middleware) {
            $this->middleware($middleware);
        }

        $this->middleware(HttpCache::class);
    }

    /**
     * Disable a middleware.
     *
     * @param $middleware
     * @return $this
     */
    protected function disableMiddleware($middleware)
    {
        foreach ($this->middleware as $key => $item) {
            if ($item['middleware'] == $middleware) {

                unset($this->middleware[$key]);

                return $this;
            }
        }

        return $this;
    }
}
