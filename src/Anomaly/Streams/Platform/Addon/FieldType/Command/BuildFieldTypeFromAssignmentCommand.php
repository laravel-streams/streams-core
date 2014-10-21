<?php namespace Anomaly\Streams\Platform\Addon\FieldType\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Entry\EntryModel;

class BuildFieldTypeFromAssignmentCommand
{
    /**
     * @var \Anomaly\Streams\Platform\Assignment\AssignmentModel
     */
    protected $assignment;

    /**
     * @var \Anomaly\Streams\Platform\Entry\EntryModel
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
     * @return \Anomaly\Streams\Platform\Assignment\AssignmentModel
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
 