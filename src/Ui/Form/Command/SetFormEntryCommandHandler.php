<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormModelInterface;

/**
 * Class SetFormEntryCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetFormEntryCommandHandler
{

    /**
     * Set the form model object from the builder's model.
     *
     * @param SetFormEntryCommand $command
     */
    public function handle(SetFormEntryCommand $command)
    {
        $builder = $command->getBuilder();
        $entry   = $builder->getEntry();
        $form    = $builder->getForm();
        $model   = $form->getModel();

        /**
         * If the entry is null or scalar and the
         * model is an instance of FormModelInterface
         * then use the model to fetch the entry
         * or create a new one.
         */
        if (is_scalar($entry) || $entry === null) {
            if ($model instanceof FormModelInterface) {
                $form->setEntry($model::findOrNew($entry));
            }
        }

        /**
         * If the entry is a plain 'ole
         * object  then just use it as is.
         */
        if (is_object($entry)) {
            $form->setEntry($entry);
        }
    }
}
