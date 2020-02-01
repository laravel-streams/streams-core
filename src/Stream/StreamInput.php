<?php

namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class StreamInput
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StreamInput
{

    /**
     * Read and process the stream input.
     *
     * @param array $stream
     * @return array
     */
    public static function read(array $stream)
    {
        return $stream;
    }
}
