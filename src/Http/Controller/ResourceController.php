<?php namespace Anomaly\Streams\Platform\Http\Controller;

/**
 * Class ResourceController
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
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
