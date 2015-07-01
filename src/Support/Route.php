<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;

/**
 * Class Route
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Route implements Arrayable
{

    /**
     * The Laravel route.
     *
     * @var \Illuminate\Routing\Route
     */
    protected $route;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new Route instance.
     *
     * @param \Illuminate\Routing\Route $route
     * @param Request                   $request
     */
    public function __construct(\Illuminate\Routing\Route $route, Request $request)
    {
        $this->route   = $route;
        $this->request = $request;
    }

    /**
     * Return the route as an array.
     *
     * @return array
     */
    public function toArray()
    {
        if (!$this->route->getUri()) {
            return [];
        }

        return [
            'uri'                      => $this->route->getUri(),
            'parameters'               => $this->route->parameters(),
            'parameters.to_urlencoded' => array_map(
                function ($parameter) {
                    return urlencode($parameter);
                },
                $this->route->parameters()
            ),
            'parameter_names'          => $this->route->parameterNames(),
            'compiled'                 => [
                'static_prefix'     => $this->route->getCompiled()->getStaticPrefix(),
                'parameters_suffix' => str_replace(
                    $this->route->getCompiled()->getStaticPrefix(),
                    '',
                    $this->request->getRequestUri()
                )
            ]
        ];
    }

    /**
     * Map calls to the route object.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    function __call($name, $arguments)
    {
        return call_user_func_array([$this->route, $name], $arguments);
    }
}
