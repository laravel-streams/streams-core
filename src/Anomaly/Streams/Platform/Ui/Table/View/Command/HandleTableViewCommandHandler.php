<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Command;

/**
 * Class HandleTableViewCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\View\Command
 */
class HandleTableViewCommandHandler
{
    /**
     * Handle the command.
     *
     * @param HandleTableViewCommand $command
     */
    public function handle(HandleTableViewCommand $command)
    {
        $table = $command->getTable();
        $query = $command->getQuery();

        $views = $table->getViews();

        if ($view = $views->active()) {
            $handler = $view->getHandler();

            if (is_string($handler) || $handler instanceof \Closure) {
                app()->call($handler, compact('table', 'query'));
            }

            if ($handler === null) {
                $view->handle($table, $query);
            }
        }
    }
}
