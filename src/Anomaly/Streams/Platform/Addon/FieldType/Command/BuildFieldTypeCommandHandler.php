<?php namespace Anomaly\Streams\Platform\Addon\FieldType\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;

class BuildFieldTypeCommandHandler
{
    public function handle(BuildFieldTypeCommand $command)
    {
        $collection = app('streams.field_types');

        if ($fieldType = $collection->findBySlug($command->getType())) {

            if ($fieldType instanceof FieldTypeAddon) {

                $fieldType->setField($command->getField());

                if ($value = $command->getValue()) {
                    $fieldType->setValue($value);
                }

                if ($label = $command->getLabel()) {
                    $fieldType->setLabel($label);
                }

                if ($locale = $command->getLocale()) {
                    $fieldType->setLocale($locale);
                }

                if ($instructions = $command->getInstructions()) {
                    $fieldType->setInstructions($instructions);
                }

                if ($placeholder = $command->getPlaceholder()) {
                    $fieldType->setPlaceholder($placeholder);
                }

                if ($prefix = $command->getPrefix()) {
                    $fieldType->setPrefix($prefix);
                }

                if ($view = $command->getView()) {
                    $fieldType->setView($view);
                }

            }

        }

        return $fieldType;
    }
}
 