<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Illuminate\Foundation\Bus\DispatchesJobs;
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
     * Create a new BaseController instance.
     */
    public function __construct()
    {
        // Let addons manipulate middleware first.
        foreach (app('Anomaly\Streams\Platform\Http\Middleware\MiddlewareCollection') as $middleware) {
            $this->middleware($middleware);
        }

        // These may be manipulated by the middleware above.
        $this->middleware('Anomaly\Streams\Platform\Http\Middleware\VerifyCsrfToken');
        $this->middleware('Anomaly\Streams\Platform\Http\Middleware\ApplicationReady');
        $this->middleware('Anomaly\Streams\Platform\Http\Middleware\ForceHttps');
    }
}
