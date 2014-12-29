<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract\ActionHandlerInterface;

/**
 * Class RunTablePostHookCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Command
 */
class RunTablePostHookCommandHandler
{

    /**
     * Handle the command.
     *
     * @param RunTablePostHookCommand $command
     */
    public function handle(RunTablePostHookCommand $command)
    {
        $event = $command->getEvent();

        $table   = $event->getTable();
        $actions = $table->getActions();

        if ($action = $actions->active()) {
            if ($action instanceof ActionHandlerInterface) {
                $action->onTablePost($command->getEvent());
            }
        }
    }
}
