<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionExecutor;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

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
     * @param ActionExecutor $executor
     * @throws \Exception
     */
    public function handle(ActionExecutor $executor)
    {
        $actions = $this->builder->getTableActions();

        if ($action = $actions->active()) {
            $executor->execute($this->builder, $action);
        }
    }
}
