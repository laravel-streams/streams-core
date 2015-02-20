<?php namespace Anomaly\Streams\Platform\Http\Controller;

/**
 * Class PublicController
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Http\Controller
 */
class PublicController extends BaseController
{

    /**
     * Create a new BaseController instance.
     */
    public function __construct()
    {
        // Skip this stuff if we're not installed yet.
        if (app('Anomaly\Streams\Platform\Application\Application')->isInstalled()) {
            $this->middleware('Anomaly\Streams\Platform\Http\Middleware\CheckSiteStatus');
        }
    }
}
