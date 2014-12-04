<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

class HandleTableCommandHandler
{

    public function handle(HandleTableCommand $command)
    {
        $builder = $command->getBuilder();

        $this->handleTableAction($builder);
    }

    protected function handleTableAction(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $actions = $table->getActions();

        if ($action = $actions->active()) {

            $ids = app('request')->get('id');

            $handler = $action->getHandler();

            if (is_string($handler) or $handler instanceof \Closure) {

                app()->call($handler, compact('table', 'ids'));
            }

            if ($handler === null) {

                $action->handle($table, $ids);
            }

            $table->setResponse(redirect(app('request')->fullUrl()));
        }
    }
}
 