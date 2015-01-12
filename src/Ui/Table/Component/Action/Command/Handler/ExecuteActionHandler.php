<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionExecutor;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\ExecuteAction;

/**
 * Class ExecuteActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Command
 */
class ExecuteActionHandler
{

    /**
     * The action executor.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionExecutor
     */
    protected $executor;

    /**
     * Create a new ExecuteActionHandler instance.
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
     * @param ExecuteAction $command
     */
    public function handle(ExecuteAction $command)
    {
        $table = $command->getTable();

        $actions = $table->getActions();

        if ($action = $actions->active()) {
            $this->executor->execute($table, $action);
        }
    }
}
