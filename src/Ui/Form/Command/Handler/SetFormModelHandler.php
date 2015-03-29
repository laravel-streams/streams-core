<?php namespace Anomaly\Streams\Platform\Ui\Form\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Command\SetFormModel;

/**
 * Class SetFormModelHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetFormModelHandler
{

    /**
     * Set the form model object from the builder's model.
     *
     * @param SetFormModel $command
     */
    public function handle(SetFormModel $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $model   = $builder->getModel();

        /**
         * If the model is already instantiated
         * then use it as is.
         */
        if (is_object($model)) {

            $form->setModel($model);

            return;
        }

        /**
         * If no model is set, try guessing the
         * model based on best practices.
         */
        if (!$model) {

            $parts = explode('\\', str_replace('FormBuilder', 'Model', get_class($builder)));

            unset($parts[count($parts) - 2]);

            $model = implode('\\', $parts);

            $builder->setModel($model);
        }

        /**
         * If the model is not set then skip it.
         */
        if (!class_exists($model)) {
            return;
        }

        /**
         * Set the model on the form!
         */
        $form->setModel(app($model));
    }
}
