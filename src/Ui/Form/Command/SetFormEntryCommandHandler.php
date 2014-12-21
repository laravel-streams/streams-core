<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
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
     * Handle the command.
     *
     * @param SetFormEntryCommand $command
     */
    public function handle(SetFormEntryCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $model   = $builder->getModel();
        $entry   = $builder->getEntry();

        $model = app($model);

        if (is_object($entry)) {
            $form->setEntry($entry);
        }

        if (is_numeric($entry) || $entry === null) {
            if ($model instanceof FormModelInterface) {
                $form->setEntry($model::findOrNew($entry));
            }
        }

        if ($model instanceof EntryInterface) {
            $form->setStream($model->getStream());
        }
    }
}
