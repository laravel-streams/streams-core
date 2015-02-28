<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Command\CreateStream;
use Anomaly\Streams\Platform\Stream\Command\DeleteStream;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class StreamManager
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream
 */
class StreamManager
{

    use DispatchesCommands;

    /**
     * Create a stream.
     *
     * @param  array $attributes
     * @return StreamInterface
     */
    public function create(array $attributes)
    {
        return $this->dispatch(new CreateStream($attributes));
    }

    /**
     * Delete a stream.
     *
     * @param StreamInterface $stream
     */
    public function delete(StreamInterface $stream)
    {
        $this->dispatch(new DeleteStream($stream));
    }
}
