<?php

namespace Anomaly\Streams\Platform\Stream;

/**
 * Class StreamFactory
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StreamFactory
{

    /**
     * Create the stream instance.
     *
     * @param array $stream
     */
    public static function make(array $stream)
    {
        $stream = new Stream($stream);

        return $stream;
    }
}
