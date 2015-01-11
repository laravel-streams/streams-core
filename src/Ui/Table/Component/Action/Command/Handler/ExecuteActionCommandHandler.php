<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionExecutor;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\ExecuteActionCommand;

/**
 * Class ExecuteActionCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Command
 */
class ExecuteActionCommandHandler
{

    /**
     * The action executor.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionExecutor
     */
    protected $executor;

    /**
     * Create a new ExecuteActionCommandHandler instance.
     *
     * @param ActionExecutor $executor
     */
    public function __construct(ActionExecutor $executor)
    {
        $this->executor = $executor;
    }

    /**
     * Handle the command.
     *
     * @param ExecuteActionCommand $command
     */
    public function handle(ExecuteActionCommand $command)
    {
        $table = $command->getTable();

        $actions = $table->getActions();

        if ($action = $actions->active()) {
            $this->executor->execute($table, $action->getHandler());
        }
    }
}
