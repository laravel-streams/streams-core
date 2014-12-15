<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormModelInterface;

/**
 * Class LoadFormEntryCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class LoadFormEntryCommandHandler
{

    /**
     * Handle the command.
     *
     * @param LoadFormEntryCommand $command
     */
    public function handle(LoadFormEntryCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $model   = $builder->getModel();
        $entry   = $builder->getEntry();

        if (is_object($entry)) {
            $form->setEntry($entry);
        }

        if (is_numeric($entry) || $entry === null) {
            if ($model instanceof FormModelInterface) {
                $form->setEntry($model::findOrNew($entry));
            }
        }
    }
}
