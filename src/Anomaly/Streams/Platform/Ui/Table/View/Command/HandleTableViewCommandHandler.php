<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Command;

class HandleTableViewCommandHandler
{

    public function handle(HandleTableViewCommand $command)
    {
        $table = $command->getTable();
        $query = $command->getQuery();

        $views = $table->getViews();

        if ($view = $views->active()) {

            $handler = $view->getHandler();

            if (is_string($handler) or $handler instanceof \Closure) {

                app()->call($handler, compact('table', 'query'));
            }

            if ($handler === null) {

                $view->handle($table, $query);
            }
        }
    }
}
 