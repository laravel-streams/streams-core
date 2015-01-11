<?php namespace Anomaly\Streams\Platform\Ui\Form\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Command\HandleFormPost;
use Anomaly\Streams\Platform\Ui\Form\Command\SaveFormInput;
use Anomaly\Streams\Platform\Ui\Form\Command\ValidateFormInput;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\SetFormResponse;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class HandleFormPostHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormPostHandler
{

    use DispatchesCommands;

    /**
     * Handle the command.
     *
     * @param HandleFormPost $command
     */
    public function handle(HandleFormPost $command)
    {
        $form = $command->getForm();

        $this->dispatch(new ValidateFormInput($form));
        $this->dispatch(new SaveFormInput($form));
        $this->dispatch(new SetFormResponse($form));
    }
}
