<?php namespace Anomaly\Streams\Platform\Support;

/**
 * Class Request
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Request
{

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
        return [
            'path' => $this->request->path(),
            'uri'  => $this->request->getRequestUri(),
        ];
    }

    /**
     * Map calls to the request object.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    function __call($name, $arguments)
    {
        return call_user_func_array([$this->request, $name], $arguments);
    }
}
