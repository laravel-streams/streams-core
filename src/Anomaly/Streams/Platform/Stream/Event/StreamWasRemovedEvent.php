<?php namespace Anomaly\Streams\Platform\Stream\Event;

use Anomaly\Streams\Platform\Stream\StreamModel;

class StreamWasRemovedEvent
{
    protected $stream;

    function __construct(StreamModel $stream)
    {
        $this->stream = $stream;
    }

    /**
     * @return mixed
     */
    public function getStream()
    {
        return $this->stream;
    }
}
 