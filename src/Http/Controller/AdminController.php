<?php namespace Anomaly\Streams\Platform\Http\Controller;

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
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
