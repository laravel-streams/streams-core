<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionExecutor;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Routing\ResponseFactory;
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
     * @param Request         $request
     * @param ActionExecutor  $executor
     * @param ResponseFactory $response
     * @throws \Exception
     */
    public function handle(Request $request, ActionExecutor $executor, ResponseFactory $response)
    {
        $actions = $this->builder->getTableActions();

        if ($action = $actions->active()) {
            $executor->execute($this->builder, $action);
        }

        if (!$this->builder->getTableResponse()) {
            $this->builder->setTableResponse($response->redirectTo($request->fullUrl()));
        }
    }
}
