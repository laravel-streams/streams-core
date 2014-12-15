<?php namespace Anomaly\Streams\Platform\Assignment\Listener;

use Anomaly\Streams\Platform\Assignment\Event\AssignmentDeletedEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class AssignmentDeletedListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment\Listener
 */
class AssignmentDeletedListener
{

    use CommanderTrait;

    /**
     * When an assignment is deleted we need to drop
     * it's database column from the entry table.
     *
     * @param AssignmentDeletedEvent $event
     */
    public function handle(AssignmentDeletedEvent $event)
    {
        $assignment = $event->getAssignment();

        $this->execute(
            'Anomaly\Streams\Platform\Assignment\Command\DropAssignmentColumnCommand',
            compact('assignment')
        );
    }
}
