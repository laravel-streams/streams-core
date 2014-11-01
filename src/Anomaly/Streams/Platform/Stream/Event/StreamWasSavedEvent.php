<?php namespace Anomaly\Streams\Platform\Stream\Event;

use Anomaly\Streams\Platform\Stream\StreamModel;

/**
 * Class StreamWasSavedEvent
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Event
 */
class StreamWasSavedEvent
{

    /**
     * The stream model object.
     *
     * @var \Anomaly\Streams\Platform\Stream\StreamModel
     */
    protected $stream;

    /**
     * Create a new StreamWasSavedEvent instance.
     *
     * @param StreamModel $stream
     */
    function __construct(StreamModel $stream)
    {
        $this->stream = $stream;
    }

    /**
     * Get the stream model object.
     *
     * @return mixed
     */
    public function getStream()
    {
        return $this->stream;
    }
}
 