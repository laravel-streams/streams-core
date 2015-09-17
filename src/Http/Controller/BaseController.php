<?php

namespace Anomaly\Streams\Platform\Http\Controller;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class BaseController.
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
     * Create a new BaseController instance.
     */
    public function __construct()
    {
        $this->request  = app('Illuminate\Http\Request');
        $this->response = app('Illuminate\Contracts\Routing\ResponseFactory');

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
