<?php

namespace Anomaly\Streams\Platform\Http\Controller;

use Anomaly\Streams\Platform\Http\Middleware\ForceSsl;
use Anomaly\Streams\Platform\Http\Middleware\PrefixDomain;
use Anomaly\Streams\Platform\Http\Middleware\SetLocale;
use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Illuminate\Routing\Controller;
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
        $this->middleware(ForceSsl::class);
        $this->middleware(PrefixDomain::class);

        $this->middleware(SetLocale::class);
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
