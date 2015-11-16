<?php namespace Anomaly\Streams\Platform\Routing;

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Str;

/**
 * Class UrlGenerator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Routing
 */
class UrlGenerator extends \Illuminate\Routing\UrlGenerator
{

    /**
     * Create a new UrlGenerator instance.
     *
     * @param RouteCollection $routes
     * @param Request         $request
     */
    public function __construct(RouteCollection $routes, Request $request)
    {
        parent::__construct($routes, $request);

        if (defined('LOCALE')) {
            $this->forceRootUrl($this->getRootUrl($this->getScheme(null)) . '/' . LOCALE);
        }
    }
}
