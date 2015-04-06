<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Listener;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionExecutor;
use Anomaly\Streams\Platform\Ui\Table\Event\TableWasPosted;
use Illuminate\Http\Request;

class ExecuteAction
{

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The action executor.
     *
     * @var ActionExecutor
     */
    protected $executor;

    /**
     * Create a new ExecuteActionHandler instance.
     *
     * @param Request        $request
     * @param ActionExecutor $executor
     */
    public function __construct(Request $request, ActionExecutor $executor)
    {
        $this->request  = $request;
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
        $builder = $event->getBuilder();
        $table   = $builder->getTable();

        $actions = $table->getActions();

        if ($action = $actions->active()) {
            $this->executor->execute($table, $action);
        }

        $table->setResponse(response()->redirectTo($this->request->fullUrl()));
    }
}
