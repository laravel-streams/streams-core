<?php namespace Streams\Platform\Assignment\Event;

class FieldWasUnassignedEvent
{
    protected $assignment;

    function __construct($assignment)
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
 