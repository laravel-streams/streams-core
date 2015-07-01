<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Routing\UrlGenerator;

/**
 * Class Url
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Url implements Arrayable
{

    /**
     * The url generator.
     *
     * @var UrlGenerator
     */
    protected $url;

    /**
     * Create a new Url instance.
     *
     * @param UrlGenerator $url
     */
    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    /**
     * Return the url as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'previous' => $this->url->previous()
        ];
    }

    /**
     * Map calls to the url generator.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    function __call($name, $arguments)
    {
        return call_user_func_array([$this->url, $name], $arguments);
    }
}
