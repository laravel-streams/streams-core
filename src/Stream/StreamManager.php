<?php namespace Anomaly\Streams\Platform\Stream;

use Laracasts\Commander\CommanderTrait;

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

    use CommanderTrait;

    /**
     * Create a stream.
     *
     * @param  array $stream
     * @return mixed
     */
    public function create(array $stream)
    {
        return $this->execute('Anomaly\Streams\Platform\Stream\Command\CreateStreamCommand', $stream);
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
        return $this->execute(
            'Anomaly\Streams\Platform\Stream\Command\DeleteStreamCommand',
            compact('namespace', 'slug')
        );
    }
}
