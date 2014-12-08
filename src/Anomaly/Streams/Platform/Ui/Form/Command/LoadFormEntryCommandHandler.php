<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormModelInterface;

class LoadFormEntryCommandHandler
{

    public function handle(LoadFormEntryCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $model   = $builder->getModel();
        $entry   = $builder->getEntry();

        if (is_object($entry)) {

            $form->setEntry($entry);
        }

        if (is_numeric($entry) or $entry === null) {

            if ($model instanceof FormModelInterface) {

                $form->setEntry($model::findOrNew($entry));
            }
        }
    }
}
 