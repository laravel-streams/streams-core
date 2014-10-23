<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Command\AddAssignmentColumnCommand;
use Anomaly\Streams\Platform\Support\Listener;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Assignment\Event\FieldWasAssignedEvent;

class AssignmentListener extends Listener
{
    use CommandableTrait;

    public function whenFieldWasAssigned(FieldWasAssignedEvent $event)
    {
        $command = new AddAssignmentColumnCommand($event->getAssignment());

        $this->execute($command);
    }
}
 