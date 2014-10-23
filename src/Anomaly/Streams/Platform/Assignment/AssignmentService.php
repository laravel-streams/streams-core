<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Addon\FieldType\Command\BuildFieldTypeCommand;
use Anomaly\Streams\Platform\Traits\CommandableTrait;

class AssignmentService
{
    use CommandableTrait;

    public function buildFieldType($assignment)
    {
        $type         = $assignment->field->type;
        $field        = $assignment->field->slug;
        $label        = $assignment->field->name;
        $instructions = $assignment->instructions;

        $command = new BuildFieldTypeCommand($type, $field, $value = null, $label, $instructions);

        return $this->execute($command);
    }
}
 