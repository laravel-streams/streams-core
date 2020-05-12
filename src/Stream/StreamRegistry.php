<?php

namespace Anomaly\Streams\Platform\Stream;

/**
 * Class StreamRegistry
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StreamRegistry
{

    /**
     * The registered streams.
     *
     * @var array
     */
    protected $streams = [];

    /**
     * Register a stream model.
     *
     * @param string $stream
     * @param string $model
     * 
     * @return $this
     */
    public function register(string $stream, string $model)
    {
        $this->streams[$stream] = $model;

        return $this;
    }

    /**
     * Get the streams.
     * 
     * @return array
     */
    public function getStreams()
    {
        return $this->streams;
    }
}
