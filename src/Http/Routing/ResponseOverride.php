<?php namespace Anomaly\Streams\Platform\Http\Routing;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResponseOverride
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Routing
 */
class ResponseOverride
{

    /**
     * The response object.
     *
     * @var null|Response
     */
    protected $response = null;

    /**
     * Return whether the response
     * override is set or not.
     *
     * @return bool
     */
    public function exists()
    {
        return !is_null($this->response);
    }

    /**
     * Get the override.
     *
     * @return null|Response
     */
    public function get()
    {
        return $this->response;
    }

    /**
     * Set the override.
     *
     * @param Response $response
     * @return $this
     */
    public function set(Response $response)
    {
        $this->response = $response;

        return $this;
    }
}
