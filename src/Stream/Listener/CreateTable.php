<?php namespace Anomaly\Streams\Platform\Stream\Listener;

use Anomaly\Streams\Platform\Stream\Command\CreateStreamsEntryTable;
use Anomaly\Streams\Platform\Stream\Event\StreamWasCreated;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class CreateTable
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream\Listener
 */
class CreateTable
{

    use DispatchesJobs;

    /**
     * When a stream is created we have some
     * generation to do. Create the streams
     * table as well as the entry models.
     *
     * @param StreamWasCreated $event
     */
    public function handle(StreamWasCreated $event)
    {
        $this->dispatch(new CreateStreamsEntryTable($event->getStream()));
    }
}
