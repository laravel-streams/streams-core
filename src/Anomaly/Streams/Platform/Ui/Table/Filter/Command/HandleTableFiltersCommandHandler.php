<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

class HandleTableFiltersCommandHandler
{

    public function handle(HandleTableFiltersCommand $command)
    {
        $table = $command->getTable();
        $query = $command->getQuery();

        $filters = $table->getFilters();

        foreach ($filters->active() as $filter) {

            $handler = $filter->getHandler();

            if (is_string($handler) || $handler instanceof \Closure) {

                app()->call($handler, compact('table', 'query'));
            }

            if ($handler === null) {

                $filter->handle($table, $query);
            }
        }
    }
}
 