<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Command\AddAssignmentColumnCommand;
use Anomaly\Streams\Platform\Assignment\Command\DropAssignmentColumnCommand;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasCreatedEvent;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentWasDeletedEvent;
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
     * Fired after an assignment was created.
     *
     * @param AssignmentWasCreatedEvent $event
     */
    public function whenAssignmentWasCreated(AssignmentWasCreatedEvent $event)
    {
        $this->execute(new AddAssignmentColumnCommand($event->getAssignment()));
    }

    /**
     * Fired after assignment was deleted.
     *
     * @param AssignmentWasDeletedEvent $event
     */
    public function whenAssignmentWasDeleted(AssignmentWasDeletedEvent $event)
    {
        $this->execute(new DropAssignmentColumnCommand($event->getAssignment()));
    }
}
 