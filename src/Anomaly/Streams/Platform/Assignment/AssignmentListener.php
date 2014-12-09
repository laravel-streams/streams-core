<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentCreatedEvent;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentDeletedEvent;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentSavedEvent;
use Anomaly\Streams\Platform\Support\Listener;
use Laracasts\Commander\CommanderTrait;

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

    use CommanderTrait;

    /**
     * When an assignment is created remove it's column.
     *
     * @param AssignmentCreatedEvent $event
     */
    public function whenAssignmentCreated(AssignmentCreatedEvent $event)
    {
        $assignment = $event->getAssignment();

        $this->execute(
            'Anomaly\Streams\Platform\Assignment\Command\AddAssignmentColumnCommand',
            compact('assignment')
        );
    }

    /**
     * When an assignment is deleted remove it's column.
     *
     * @param AssignmentDeletedEvent $event
     */
    public function whenAssignmentDeleted(AssignmentDeletedEvent $event)
    {
        $assignment = $event->getAssignment();

        $this->execute(
            'Anomaly\Streams\Platform\Assignment\Command\DropAssignmentColumnCommand',
            compact('assignment')
        );
    }

    /**
     * When an assignment is saved, save it's stream to trigger compiling.
     *
     * @param AssignmentSavedEvent $event
     */
    public function whenAssignmentSaved(AssignmentSavedEvent $event)
    {
        $assignment = $event->getAssignment();

        $stream = $assignment->getStream();

        $stream->compile();
    }
}
 