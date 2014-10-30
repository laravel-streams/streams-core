<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Stream\StreamModel;

class GenerateEntryModelCommand
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
 