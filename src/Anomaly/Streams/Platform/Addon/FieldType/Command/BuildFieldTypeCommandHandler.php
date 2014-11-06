<?php namespace Anomaly\Streams\Platform\Addon\FieldType\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

/**
 * Class BuildFieldTypeCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType\Command
 */
class BuildFieldTypeCommandHandler
{

    /**
     * Handle the command.
     *
     * @param BuildFieldTypeCommand $command
     * @return mixed
     */
    public function handle(BuildFieldTypeCommand $command)
    {
        $fieldType = $this->getFieldType($command);

        if ($fieldType) {

            if ($fieldType instanceof FieldType) {

                $fieldType
                    ->setField($command->getField())
                    ->setValue($command->getValue())
                    ->setLabel($command->getLabel())
                    ->setLocale($command->getLocale())
                    ->setPrefix($command->getPrefix())
                    ->setPlaceholder($command->getPlaceholder())
                    ->setInstructions($command->getInstructions());

                if ($view = $command->getView()) {

                    $fieldType->setView($command->getView());
                }
            }
        }

        return $fieldType;
    }

    /**
     * Get the field type class.
     *
     * @param BuildFieldTypeCommand $command
     * @return mixed
     */
    protected function getFieldType(BuildFieldTypeCommand $command)
    {
        if (class_exists($command->getType())) {

            return app($command->getType());
        }

        return app('streams.field_types')->findBySlug($command->getType());
    }
}
 