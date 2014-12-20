<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

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

        foreach ($actions->active() as $action) {
            $this->runTablePostHook($action, $builder);
        }
    }

    /**
     * Ryan a action's post hook.
     *
     * @param ActionInterface $action
     * @param TableBuilder    $builder
     */
    protected function runTableQueryHook(ActionInterface $action, TableBuilder $builder)
    {
        $action->runTablePostHook($builder);
    }
}
