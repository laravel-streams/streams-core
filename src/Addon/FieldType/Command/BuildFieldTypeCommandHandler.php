<?php namespace Anomaly\Streams\Platform\Addon\FieldType\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

/**
 * Class BuildFieldTypeCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\FieldType\Command
 */
class BuildFieldTypeCommandHandler
{

    /**
     * Handle the command.
     *
     * @param  BuildFieldTypeCommand $command
     * @return mixed
     */
    public function handle(BuildFieldTypeCommand $command)
    {
        $fieldType = $this->getFieldType($command);

        $fieldType
            ->setField($command->getField())
            ->setValue($command->getValue())
            ->setLabel($command->getLabel())
            ->setLocale($command->getLocale())
            ->setPrefix($command->getPrefix())
            ->setHidden($command->getHidden())
            ->setConfig($command->getConfig())
            ->setRequired($command->getRequired())
            ->setPlaceholder($command->getPlaceholder())
            ->setTranslatable($command->getTranslatable())
            ->setInstructions($command->getInstructions());

        if ($inputView = $command->getInputView()) {
            $fieldType->setInputView($inputView);
        }

        if ($filterView = $command->getFilterView()) {
            $fieldType->setFilterView($filterView);
        }

        if ($wrapperView = $command->getWrapperView()) {
            $fieldType->setWrapperView($wrapperView);
        }

        return $fieldType;
    }

    /**
     * Get the field type class.
     *
     * @param  BuildFieldTypeCommand $command
     * @return FieldType
     */
    protected function getFieldType(BuildFieldTypeCommand $command)
    {
        $fieldType = $command->getType();

        if ($fieldType instanceof FieldType) {
            return $fieldType;
        }

        if (starts_with($fieldType, 'Anomaly') && class_exists($fieldType)) {
            return app($command->getType());
        }

        return app('streams.field_types')->findBySlug($fieldType)->newInstance();
    }
}
