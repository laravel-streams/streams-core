<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Anomaly\Streams\Platform\Stream\StreamModel;

class CreateStreamsEntryTableCommand
{
    protected $stream;

    function __construct(StreamModel $stream)
    {
        $this->stream = $stream;
    }

    public function getStream()
    {
        return $this->stream;
    }
}
 