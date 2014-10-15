<?php namespace Streams\Platform\Addon\FieldType\Command;

use Streams\Platform\Assignment\AssignmentModel;

class BuildFieldTypeFromAssignmentCommand
{
    /**
     * @var \Streams\Platform\Assignment\AssignmentModel
     */
    protected $assignment;

    /**
     * @param AssignmentModel $assignment
     */
    function __construct(AssignmentModel $assignment)
    {
        $this->assignment = $assignment;
    }

    /**
     * @return \Streams\Platform\Assignment\AssignmentModel
     */
    public function getAssignment()
    {
        return $this->assignment;
    }
}
 