<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Laracasts\Commander\CommanderTrait;

/**
 * Class HandleFormPostCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormPostCommandHandler
{

    use CommanderTrait;

    /**
     * Handle the command.
     *
     * @param HandleFormPostCommand $command
     */
    public function handle(HandleFormPostCommand $command)
    {
        $form = $command->getForm();

        $this->execute(
            'Anomaly\Streams\Platform\Ui\Form\Command\ValidateFormInputCommand',
            compact('form')
        );
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Form\Command\SaveFormInputCommand',
            compact('form')
        );
        $this->execute(
            'Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\SetFormResponseCommand',
            compact('form')
        );
    }
}
