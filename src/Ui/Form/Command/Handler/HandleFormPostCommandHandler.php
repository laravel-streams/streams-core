<?php namespace Anomaly\Streams\Platform\Ui\Form\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Command\HandleFormPostCommand;
use Anomaly\Streams\Platform\Ui\Form\Command\SaveFormInputCommand;
use Anomaly\Streams\Platform\Ui\Form\Command\ValidateFormInputCommand;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\SetFormResponseCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;

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

    use DispatchesCommands;

    /**
     * Handle the command.
     *
     * @param HandleFormPostCommand $command
     */
    public function handle(HandleFormPostCommand $command)
    {
        $form = $command->getForm();

        $this->dispatch(new ValidateFormInputCommand($form));
        $this->dispatch(new SaveFormInputCommand($form));
        $this->dispatch(new SetFormResponseCommand($form));
    }
}
