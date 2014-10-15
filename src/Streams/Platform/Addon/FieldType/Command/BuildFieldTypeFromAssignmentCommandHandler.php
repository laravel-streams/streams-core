<?php namespace Streams\Platform\Addon\FieldType\Command;

use Streams\Platform\Contract\HandlerInterface;

class BuildFieldTypeFromAssignmentHandlerHandler implements HandlerInterface
{
    public function handle($command)
    {
        $assignment = $command->getAssignment();

        $field = $assignment->field;
        $type  = $assignment->type;

        $settings = array_merge($field->settings, $assignment->settings);

        $type->setSettings($settings);

        return $type;
    }
}
 