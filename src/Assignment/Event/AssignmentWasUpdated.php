<?php namespace Anomaly\Streams\Platform\Assignment\Event;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;

/**
 * Class AssignmentWasUpdated
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment\Event
 */
class AssignmentWasUpdated
{

    /**
     * The assignment interface.
     *
     * @var AssignmentInterface
     */
    protected $assignment;

    /**
     * Create a new AssignmentWasUpdated instance.
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
     * @return AssignmentInterface
     */
    public function getAssignment()
    {
        return $this->assignment;
    }
}
