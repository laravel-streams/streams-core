<?php namespace Anomaly\Streams\Platform\Stream\Listener;

use Anomaly\Streams\Platform\Stream\Event\StreamDeletedEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class StreamDeletedListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream\Listener
 */
class StreamDeletedListener
{

    use CommanderTrait;

    /**
     * When a stream is deleted we need to
     * drop the database table.
     *
     * @param StreamDeletedEvent $event
     */
    public function handle(StreamDeletedEvent $event)
    {
        $stream = $event->getStream();

        $this->execute(
            'Anomaly\Streams\Platform\Stream\Command\DropStreamsEntryTableCommand',
            compact('stream')
        );
    }
}
