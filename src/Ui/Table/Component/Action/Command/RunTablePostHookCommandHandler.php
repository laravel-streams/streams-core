<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Command;

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
            $action->onTablePost($command->getEvent());
        }
    }
}
