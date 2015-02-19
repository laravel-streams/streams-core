<?php namespace Anomaly\Streams\Platform\Assignment\Listener;

use Anomaly\Streams\Platform\Assignment\Command\DropAssignmentColumn;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasDeleted;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class DropTableColumn
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment\Listener
 */
class DropTableColumn
{

    use DispatchesCommands;

    /**
     * When an assignment is deleted we need to drop
     * it's database column from the entry table.
     *
     * @param AssignmentWasDeleted $event
     */
    public function handle(AssignmentWasDeleted $event)
    {
        $assignment = $event->getAssignment();

        $this->dispatch(new DropAssignmentColumn($assignment));
    }
}
