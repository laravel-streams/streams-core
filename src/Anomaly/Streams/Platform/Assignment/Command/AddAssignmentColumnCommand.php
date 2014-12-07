<?php namespace Anomaly\Streams\Platform\Assignment\Command;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;

/**
 * Class AddAssignmentColumnCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment\Command
 */
class AddAssignmentColumnCommand
{

    /**
     * The assignment interface.
     *
     * @var \Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface
     */
    protected $assignment;

    /**
     * Create a new AddAssignmentColumnCommand instance.
     *
     * @param AssignmentInterface $assignment
     */
    function __construct(AssignmentInterface $assignment)
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
 