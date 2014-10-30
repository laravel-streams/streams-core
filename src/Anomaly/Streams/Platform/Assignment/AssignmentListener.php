<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Command\AddAssignmentColumnCommand;
use Anomaly\Streams\Platform\Assignment\Command\DropAssignmentColumnCommand;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasCreatedEvent;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasDeletedEvent;
use Anomaly\Streams\Platform\Support\Listener;
use Anomaly\Streams\Platform\Traits\CommandableTrait;

class AssignmentListener extends Listener
{

    use CommandableTrait;

    public function whenAssignmentWasCreated(AssignmentWasCreatedEvent $event)
    {
        $command = new AddAssignmentColumnCommand($event->getAssignment());

        $this->execute($command);
    }

    public function whenAssignmentWasDeleted(AssignmentWasDeletedEvent $event)
    {
        $command = new DropAssignmentColumnCommand($event->getAssignment());

        $this->execute($command);
    }
}
 