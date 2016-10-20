<?php namespace Anomaly\Streams\Platform\Http\Controller;

/**
 * Class ResourceController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ResourceController extends PublicController
{

    /**
     * Create a new ResourceController instance.
     */
    public function __construct()
    {
        parent::__construct();

        // No CSRF protection.
        unset($this->middleware['Anomaly\Streams\Platform\Http\Middleware\VerifyCsrfToken']);
    }
}
