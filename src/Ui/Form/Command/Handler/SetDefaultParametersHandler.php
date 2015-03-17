<?php namespace Anomaly\Streams\Platform\Ui\Form\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Command\SetDefaultParameters;

/**
 * Class SetDefaultParametersHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetDefaultParametersHandler
{

    /**
     * Set the form model object from the builder's model.
     *
     * @param SetDefaultParameters $command
     */
    public function handle(SetDefaultParameters $command)
    {
        $builder = $command->getBuilder();

        /**
         * Set the default fields handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$builder->getFields()) {

            $fields = str_replace('FormBuilder', 'FormFields', get_class($builder));

            if (class_exists($fields)) {
                $builder->setFields($fields . '@handle');
            } else {
                $builder->setFields(['*']);
            }
        }

        /**
         * Set the default actions handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$builder->getActions()) {

            $actions = str_replace('FormBuilder', 'FormActions', get_class($builder));

            if (class_exists($actions)) {
                $builder->setActions($actions . '@handle');
            }
        }

        /**
         * Set the default buttons handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$builder->getButtons()) {

            $buttons = str_replace('FormBuilder', 'FormButtons', get_class($builder));

            if (class_exists($buttons)) {
                $builder->setButtons($buttons . '@handle');
            }
        }
    }
}
