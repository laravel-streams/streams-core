<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

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
     * @return StreamInterface
     */
    public function make($stream)
    {
        return App::make('streams::' . $stream);
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

    /**
     * Try making a stream instance.
     *
     * @param string $stream
     * @param \Closure|null $callback
     * @return null|StreamInterface
     */
    public function try($stream, $callback = null)
    {
        try {
            
            $stream = $this->make($stream);

            if ($callback) {
                $stream = App::call($callback, compact('stream'));
            }

            return $stream;
        } catch (\Exception $e) {
            return null;
        }
    }
}
