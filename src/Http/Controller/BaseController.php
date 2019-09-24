<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Anomaly\Streams\Platform\Asset\Asset;
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
use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\Streams\Platform\Routing\UrlGenerator;
use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route;

/**
 * Class BaseController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BaseController extends Controller
{

    /**
     * The route object.
     *
     * @var Route
     */
    protected $route;

    /**
     * The flash messages.
     *
     * @var MessageBag
     */
    protected $messages;

    /**
     * The view template.
     *
     * @var ViewTemplate
     */
    protected $template;

    /**
     * The breadcrumb collection.
     *
     * @var BreadcrumbCollection
     */
    protected $breadcrumbs;

    /**
     * Create a new BaseController instance.
     */
    public function __construct()
    {
        event(new Response($this));

        $this->middleware(PoweredBy::class);

        $this->middleware(VerifyCsrfToken::class);

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
