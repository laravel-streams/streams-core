<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Listener;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionExecutor;
use Anomaly\Streams\Platform\Ui\Table\Event\TableWasPosted;

class ExecuteAction
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
     * Handle the event.
     *
     * @param TableWasPosted $event
     * @throws \Exception
     */
    public function handle(TableWasPosted $event)
    {
        $table = $event->getTable();

        $actions = $table->getActions();

        if ($action = $actions->active()) {
            $this->executor->execute($table, $action);
        }
    }
}
