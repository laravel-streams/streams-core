<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Command\DeleteStream;
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
     * @param  array $stream
     * @return mixed
     */
    public function create(array $stream)
    {
        return $this->dispatchFromArray('Anomaly\Streams\Platform\Stream\Command\CreateStream', $stream);
    }

    /**
     * Delete a stream.
     *
     * @param  $namespace
     * @param  $slug
     * @return mixed
     */
    public function delete($namespace, $slug)
    {
        return $this->dispatch(new DeleteStream($namespace, $slug));
    }
}
