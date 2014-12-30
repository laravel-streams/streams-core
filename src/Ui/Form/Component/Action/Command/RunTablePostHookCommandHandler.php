<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Command;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract\ActionHandlerInterface;

/**
 * Class RunFormPostHookCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action\Command
 */
class RunFormPostHookCommandHandler
{

    /**
     * Handle the command.
     *
     * @param RunFormPostHookCommand $command
     */
    public function handle(RunFormPostHookCommand $command)
    {
        $event = $command->getEvent();

        $form   = $event->getForm();
        $actions = $form->getActions();

        if ($action = $actions->active()) {
            if ($action instanceof ActionHandlerInterface) {
                $action->onFormPost($command->getEvent());
            }
        }
    }
}
