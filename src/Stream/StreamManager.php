<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Stream\Stream;

/**
 * Class StreamManager
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamManager
{

    /**
     * Make a stream instance.
     *
     * @param string $stream
     * @return Stream
     */
    public function make($stream)
    {
        return App::make('streams.instances.' . $stream);
    }

    /**
     * Return an entry criteria.
     * 
     * @return CriteriaInterface
     */
    function entries($stream)
    {
        return $this
            ->make($stream)
            ->repository()
            ->newCriteria();
    }
}
