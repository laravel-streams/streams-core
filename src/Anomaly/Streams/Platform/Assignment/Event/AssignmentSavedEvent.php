<?php namespace Anomaly\Streams\Platform\Assignment\Event;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;

/**
 * Class AssignmentSavedEvent
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment\Event
 */
class AssignmentSavedEvent
{

    /**
     * The assignment interface.
     *
     * @var \Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface
     */
    protected $assignment;

    /**
     * Create a new AssignmentSavedEvent instance.
     *
     * @param AssignmentInterface $assignment
     */
    public function __construct(AssignmentInterface $assignment)
    {
        $this->assignment = $assignment;
    }

    /**
     * Get the assignment interface.
     *
     * @return \Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface
     */
    public function getAssignment()
    {
        return $this->assignment;
    }
}
