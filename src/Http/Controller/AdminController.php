<?php namespace Anomaly\Streams\Platform\Http\Controller;

use Anomaly\Streams\Platform\Http\Middleware\MiddlewareCollection;

/**
 * Class AdminController
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Http\Controller
 */
class AdminController extends BaseController
{

    /**
     * Create a new AdminController instance.
     *
     * @param MiddlewareCollection $middleware
     */
    public function __construct(MiddlewareCollection $middleware)
    {

        /**
         * The authenticate middleware in
         * Laravel is re-bound in the Users
         * module unless you are not using
         * the core Users module.
         */
        $this->middleware('auth');

        $this->middleware('Anomaly\Streams\Platform\Http\Middleware\AuthorizeModuleAccess');

        parent::__construct($middleware);
    }
}
