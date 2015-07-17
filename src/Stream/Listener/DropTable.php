<?php namespace Anomaly\Streams\Platform\Stream\Listener;

use Anomaly\Streams\Platform\Stream\Command\DropStreamsEntryTable;
use Anomaly\Streams\Platform\Stream\Event\StreamWasDeleted;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class DropTable
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream\Listener
 */
class DropTable
{

    use DispatchesJobs;

    /**
     * When a stream is deleted we need to
     * drop the database table.
     *
     * @param StreamWasDeleted $event
     */
    public function handle(StreamWasDeleted $event)
    {
        $this->dispatch(new DropStreamsEntryTable($event->getStream()));
    }
}
