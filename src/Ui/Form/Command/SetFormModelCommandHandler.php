<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

/**
 * Class SetFormModelCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetFormModelCommandHandler
{

    /**
     * Set the form model object from the builder's model.
     *
     * @param SetFormModelCommand $command
     */
    public function handle(SetFormModelCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $model   = $builder->getModel();

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
