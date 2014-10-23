<?php namespace Anomaly\Streams\Platform\Assignment\Command;

class AddAssignmentColumnCommand
{
    protected $assignment;

    function __construct($assignment)
    {
        $this->assignment = $assignment;
    }

    public function getAssignment()
    {
        return $this->assignment;
    }
}
 