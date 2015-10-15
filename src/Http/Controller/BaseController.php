<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Anomaly\Streams\Platform\Event\Response;
use Anomaly\Streams\Platform\Message\MessageBag;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class BaseController
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Http\Controller
 */
class BaseController extends Controller
{

    use DispatchesJobs;

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The response factory.
     *
     * @var ResponseFactory
     */
    protected $response;

    /**
     * The flash messages.
     *
     * @var MessageBag
     */
    protected $messages;

    /**
     * Create a new BaseController instance.
     */
    public function __construct()
    {
        $this->request  = app('Illuminate\Http\Request');
        $this->events   = app('Illuminate\Contracts\Events\Dispatcher');
        $this->response = app('Illuminate\Contracts\Routing\ResponseFactory');
        $this->messages = app('Anomaly\Streams\Platform\Message\MessageBag');

        $this->events->fire(new Response($this));

        // Let addons manipulate middleware first.
        foreach (app('Anomaly\Streams\Platform\Http\Middleware\MiddlewareCollection') as $middleware) {
            $this->middleware($middleware);
        }

        // These may be manipulated by the middleware above.
        $this->middleware('Anomaly\Streams\Platform\Http\Middleware\CheckForMaintenanceMode');
        $this->middleware('Anomaly\Streams\Platform\Http\Middleware\VerifyCsrfToken');
        $this->middleware('Anomaly\Streams\Platform\Http\Middleware\ApplicationReady');
        $this->middleware('Anomaly\Streams\Platform\Http\Middleware\ForceHttps');
        $this->middleware('Barryvdh\HttpCache\Middleware\CacheRequests');
    }
}
