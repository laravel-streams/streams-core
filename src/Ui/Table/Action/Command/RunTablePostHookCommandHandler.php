<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

/**
 * Class RunTablePostHookCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action\Command
 */
class RunTablePostHookCommandHandler
{

    /**
     * Apply active table actions.
     *
     * @param RunTablePostHookCommand $command
     */
    public function handle(RunTablePostHookCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $actions = $table->getActions();

        if ($action = $actions->active()) {
            $action->tablePostHandler($builder);
        }
    }
}
