<?php namespace Anomaly\Streams\Platform\Ui\Form\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Command\LoadForm;

/**
 * Class LoadFormHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class LoadFormHandler
{

    /**
     * Handle the command.
     *
     * @param LoadForm $command
     */
    public function handle(LoadForm $command)
    {
        $form = $command->getForm();

        $data = $form->getData();

        $options = $form->getOptions();

        if ($form->getStream()) {
            $options->translatable = $form->getStream()->isTranslatable();
        }

        $data->put('form', $form);
    }
}
