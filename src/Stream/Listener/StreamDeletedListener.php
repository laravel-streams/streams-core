<?php namespace Anomaly\Streams\Platform\Stream\Listener;

use Anomaly\Streams\Platform\Stream\Command\DropStreamsEntryTableCommand;
use Anomaly\Streams\Platform\Stream\Event\StreamDeletedEvent;
use Illuminate\Foundation\Bus\DispatchesCommands;

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

    use DispatchesCommands;

    /**
     * When a stream is deleted we need to
     * drop the database table.
     *
     * @param StreamDeletedEvent $event
     */
    public function handle(StreamDeletedEvent $event)
    {
        $stream = $event->getStream();

        $this->dispatch(new DropStreamsEntryTableCommand($stream));
    }
}
