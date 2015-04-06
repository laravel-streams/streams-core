<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionExecutor;
use Anomaly\Streams\Platform\Ui\Table\Event\TableWasPosted;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;

class ExecuteAction implements SelfHandling
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new ExecuteAction instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param Request        $request
     * @param ActionExecutor $executor
     * @throws \Exception
     */
    public function handle(Request $request, ActionExecutor $executor)
    {
        $table = $this->builder->getTable();

        $actions = $table->getActions();

        if ($action = $actions->active()) {
            $executor->execute($table, $action);
        }

        $table->setResponse(response()->redirectTo($request->fullUrl()));
    }
}
