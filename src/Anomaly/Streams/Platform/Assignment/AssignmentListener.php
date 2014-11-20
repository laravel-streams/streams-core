<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Command\AddAssignmentColumnCommand;
use Anomaly\Streams\Platform\Assignment\Command\DropAssignmentColumnCommand;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentCreatedEvent;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentDeletedEvent;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentSavedEvent;
use Anomaly\Streams\Platform\Support\Listener;
use Anomaly\Streams\Platform\Traits\CommandableTrait;

/**
 * Class AssignmentListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment
 */
class AssignmentListener extends Listener
{

    use CommandableTrait;

    /**
     * When an assignment is created remove it's column.
     *
     * @param AssignmentCreatedEvent $event
     */
    public function whenAssignmentCreated(AssignmentCreatedEvent $event)
    {
        $this->execute(new AddAssignmentColumnCommand($event->getAssignment()));
    }

    /**
     * When an assignment is deleted remove it's column.
     *
     * @param AssignmentDeletedEvent $event
     */
    public function whenAssignmentDeleted(AssignmentDeletedEvent $event)
    {
        $this->execute(new DropAssignmentColumnCommand($event->getAssignment()));
    }

    /**
     * When an assignment is saved, save it's stream to trigger compiling.
     *
     * @param AssignmentSavedEvent $event
     */
    public function whenAssignmentSaved(AssignmentSavedEvent $event)
    {
        $assignment = $event->getAssignment();

        $assignment->getStream()->save();
    }
}
 