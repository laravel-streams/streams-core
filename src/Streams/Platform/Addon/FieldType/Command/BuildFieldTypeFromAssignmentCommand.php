<?php namespace Streams\Platform\Addon\FieldType\Command;

use Streams\Platform\Assignment\AssignmentModel;
use Streams\Platform\Entry\EntryModel;

class BuildFieldTypeFromAssignmentCommand
{
    /**
     * @var \Streams\Platform\Assignment\AssignmentModel
     */
    protected $assignment;

    /**
     * @var \Streams\Platform\Entry\EntryModel
     */
    protected $entry;

    /**
     * @param AssignmentModel $assignment
     */
    function __construct(AssignmentModel $assignment, EntryModel $entry = null)
    {
        $this->assignment = $assignment;
        $this->entry      = $entry;
    }

    /**
     * @return \Streams\Platform\Assignment\AssignmentModel
     */
    public function getAssignment()
    {
        return $this->assignment;
    }

    /**
     * @return EntryModel
     */
    public function getEntry()
    {
        return $this->entry;
    }
}
 