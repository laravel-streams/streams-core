<?php namespace Anomaly\Streams\Platform\Assignment\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;

class DropAssignmentColumnCommand
{
    protected $assignment;

    function __construct(AssignmentModel $assignment)
    {
        $this->assignment = $assignment;
    }

    public function getAssignment()
    {
        return $this->assignment;
    }
}
 