<?php namespace Streams\Platform\Addon\FieldType\Command;

class BuildFieldTypeFromAssignmentCommandHandler
{
    public function handle(BuildFieldTypeFromAssignmentCommand $command)
    {
        $assignment = $command->getAssignment();

        $field = $assignment->field;
        $type  = $assignment->type;

        $settings = array_merge($field->settings, $assignment->settings);

        $type->setSettings($settings);

        return $type;
    }
}
 