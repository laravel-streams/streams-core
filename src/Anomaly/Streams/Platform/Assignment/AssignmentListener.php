<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentCreated;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentDeleted;
use Anomaly\Streams\Platform\Assignment\Event\AssignmentSaved;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\EventListener;

/**
 * Class AssignmentListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment
 */
class AssignmentListener extends EventListener
{

    use CommanderTrait;

    /**
     * When an assignment is created remove it's column.
     *
     * @param AssignmentCreated $event
     */
    public function whenAssignmentCreated(AssignmentCreated $event)
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
     * @param AssignmentDeleted $event
     */
    public function whenAssignmentDeleted(AssignmentDeleted $event)
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
     * @param AssignmentSaved $event
     */
    public function whenAssignmentSaved(AssignmentSaved $event)
    {
        $assignment = $event->getAssignment();

        $stream = $assignment->getStream();

        $stream->compile();
    }
}
 