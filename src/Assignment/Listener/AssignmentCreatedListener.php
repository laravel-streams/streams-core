<?php namespace Anomaly\Streams\Platform\Assignment\Listener;

use Anomaly\Streams\Platform\Assignment\Command\AddAssignmentColumnCommand;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentCreatedEvent;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class AssignmentCreatedListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment\Listener
 */
class AssignmentCreatedListener
{

    use DispatchesCommands;

    /**
     * When an assignment is created we need to
     * add it's database column to the entry table.
     *
     * @param AssignmentCreatedEvent $event
     */
    public function handle(AssignmentCreatedEvent $event)
    {
        $assignment = $event->getAssignment();

        $this->dispatch(new AddAssignmentColumnCommand($assignment));
    }
}
