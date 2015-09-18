<?php

namespace Anomaly\Streams\Platform\Support;

/**
 * Class Request.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Request
{
    /**
     * The output cache.
     *
     * @var array
     */
    protected $cache = [];

    /**
     * The request object.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new Request instance.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->request = $request;
    }

    /**
     * Return the request as an array.
     *
     * @return array
     */
    public function toArray()
    {
        if ($this->cache) {
            return $this->cache;
        }

        $request = [
            'path' => $this->request->path(),
            'uri'  => $this->request->getRequestUri(),
        ];

        if ($route = $this->request->route()) {
            $request['route'] = [
                'uri'                      => $route->getUri(),
                'parameters'               => $route->parameters(),
                'parameters.to_urlencoded' => array_map(
                    function ($parameter) {
                        return urlencode($parameter);
                    },
                    $route->parameters()
                ),
                'parameter_names'          => $route->parameterNames(),
                'compiled'                 => [
                    'static_prefix'     => $route->getCompiled()->getStaticPrefix(),
                    'parameters_suffix' => str_replace(
                        $route->getCompiled()->getStaticPrefix(),
                        '',
                        $this->request->getRequestUri()
                    ),
                ],
            ];
        }

        return $this->cache = $request;
    }

    /**
     * Map calls to the request object.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->request, $name], $arguments);
    }
}
