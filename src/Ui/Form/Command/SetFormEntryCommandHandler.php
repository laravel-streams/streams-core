<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormModelInterface;

/**
 * Class SetTableEntryCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class SetTableEntryCommandHandler
{

    /**
     * Set the form model object from the builder's model.
     *
     * @param SetTableEntryCommand $command
     */
    public function handle(SetTableEntryCommand $command)
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
