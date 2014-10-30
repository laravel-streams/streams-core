<?php namespace Anomaly\Streams\Platform\Assignment\Event;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;

class AssignmentWasDeletedEvent
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
 