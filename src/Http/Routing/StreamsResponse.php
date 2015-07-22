<?php namespace Anomaly\Streams\Platform\Http\Routing;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class StreamsResponse
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Routing
 */
class StreamsResponse
{

    /**
     * The streams response.
     *
     * @var null|Response
     */
    protected $response = null;

    /**
     * Return whether the streams
     * response is set or not.
     *
     * @return bool
     */
    public function exists()
    {
        return !is_null($this->response);
    }

    /**
     * Get the response.
     *
     * @return null|Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set the response.
     *
     * @param Response $response
     * @return $this
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;

        return $this;
    }
}
