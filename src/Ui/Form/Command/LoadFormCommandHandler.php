<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

/**
 * Class LoadFormCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class LoadFormCommandHandler
{

    /**
     * Handle the command.
     *
     * @param LoadFormCommand $command
     */
    public function handle(LoadFormCommand $command)
    {
        $form = $command->getForm();

        $data = $form->getData();

        $data->put('form', $form);
    }
}
