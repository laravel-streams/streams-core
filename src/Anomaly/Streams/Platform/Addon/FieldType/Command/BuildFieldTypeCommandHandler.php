<?php namespace Anomaly\Streams\Platform\Addon\FieldType\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;

class BuildFieldTypeCommandHandler
{
    public function handle(BuildFieldTypeCommand $command)
    {
        $collection = app('streams.field_types');

        if ($fieldType = $collection->findBySlug($command->getType())) {

            if ($fieldType instanceof FieldTypeAddon) {

                $fieldType
                    ->setView($command->getView())
                    ->setField($command->getField())
                    ->setValue($command->getValue())
                    ->setLabel($command->getLabel())
                    ->setLocale($command->getLocale())
                    ->setPrefix($command->getPrefix())
                    ->setPlaceholder($command->getPlaceholder())
                    ->setInstructions($command->getInstructions());

            }

        }

        return $fieldType;
    }
}
 