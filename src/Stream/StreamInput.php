<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Support\Facades\Locator;

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
        if ($model = Arr::get($stream, 'model')) {
            $stream['location'] = Locator::locate($model);
        }

        return $stream;
    }
}
