<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Addon\FieldType\Command\BuildFieldTypeCommand;

class AssignmentService
{
    use CommandableTrait;

    public function buildFieldType($assignment, $entry = null)
    {
        $type         = $assignment->field->type;
        $field        = $assignment->field->slug;
        $label        = $assignment->field->name;
        $instructions = $assignment->instructions;

        $command = new BuildFieldTypeCommand($type, $field, $value = null, $label, $instructions);

        $fieldType = $this->execute($command);

        if ($entry) {

            $fieldType->setValue($entry->{$field});

        }

        return $fieldType;
    }
}
 