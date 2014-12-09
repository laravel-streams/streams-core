<?php namespace Anomaly\Streams\Platform\Stream\Event;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class StreamCreated
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Event
 */
class StreamCreated
{

    /**
     * The stream interface.
     *
     * @var \Anomaly\Streams\Platform\Stream\Contract\StreamInterface
     */
    protected $stream;

    /**
     * Create a new StreamCreated instance.
     *
     * @param StreamInterface $stream
     */
    function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    /**
     * Get the stream interface.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }
}
 