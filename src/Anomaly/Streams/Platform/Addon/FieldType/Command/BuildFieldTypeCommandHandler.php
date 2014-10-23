<?php namespace Anomaly\Streams\Platform\Addon\FieldType\Command;

class BuildFieldTypeCommandHandler
{
    public function handle(BuildFieldTypeCommand $command)
    {
        $collection = app('streams.field_types');

        if ($fieldType = $collection->findBySlug($command->getType())) {

            $fieldType
                ->setField($command->getField())
                ->setValue($command->getValue())
                ->setLabel($command->getLabel())
                ->setLocale($command->getLocale())
                ->setInstructions($command->getInstructions())
                ->setPlaceholder($command->getPlaceholder())
                ->setPrefix($command->getPrefix())
                ->setView($command->getView());

        }

        return $fieldType;
    }
}
 