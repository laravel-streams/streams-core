<?php namespace Anomaly\Streams\Platform\Assignment\Command;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;

/**
 * Class DropAssignmentColumn
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment\Command
 */
class DropAssignmentColumn
{

    /**
     * The assignment interface.
     *
     * @var \Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface
     */
    protected $assignment;

    /**
     * Create a new DropAssignmentColumn instance.
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
