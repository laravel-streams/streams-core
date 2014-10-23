<?php namespace Anomaly\Streams\Platform\Assignment\Event;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;

class FieldWasAssignedEvent
{
    protected $assignment;

    function __construct(AssignmentModel $assignment)
    {
        $this->assignment = $assignment;
    }

    /**
     * @return mixed
     */
    public function getAssignment()
    {
        return $this->assignment;
    }
}
 