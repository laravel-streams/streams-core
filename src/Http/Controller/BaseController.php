<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Illuminate\Foundation\Bus\DispatchesCommands;
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

    use DispatchesCommands;

    /**
     * Create a new BaseController instance.
     */
    public function __construct()
    {
        // Skip this stuff if we're not installed yet.
        if (app('Anomaly\Streams\Platform\Application\Application')->isInstalled()) {
            $this->middleware('Anomaly\Streams\Platform\Http\Middleware\SetLocale');
            $this->middleware('Anomaly\Streams\Platform\Http\Middleware\ForceHttps');
            $this->middleware('Anomaly\Streams\Platform\Http\Middleware\CheckSiteStatus');
        }
    }
}
