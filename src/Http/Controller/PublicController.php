<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Anomaly\Streams\Platform\Http\Middleware\MiddlewareCollection;

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
     *
     * @param MiddlewareCollection $middleware
     */
    public function __construct(MiddlewareCollection $middleware)
    {
        parent::__construct($middleware);

        $this->middleware('Anomaly\Streams\Platform\Http\Middleware\CheckSiteStatus');
    }
}
