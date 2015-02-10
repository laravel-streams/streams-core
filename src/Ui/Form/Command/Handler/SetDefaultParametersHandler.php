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
            }
        }
    }
}
