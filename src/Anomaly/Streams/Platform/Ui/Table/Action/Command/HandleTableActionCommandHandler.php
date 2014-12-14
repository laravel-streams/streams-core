<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

/**
 * Class HandleTableActionCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action\Command
 */
class HandleTableActionCommandHandler
{
    /**
     * Handle the command.
     *
     * @param HandleTableActionCommand $command
     */
    public function handle(HandleTableActionCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $actions = $table->getActions();

        if ($action = $actions->active()) {
            $ids = app('request')->get($table->getPrefix() . 'id');

            $handler = $action->getHandler();

            if (is_string($handler) || $handler instanceof \Closure) {
                app()->call($handler, compact('table', 'ids'));
            }

            if ($handler === null) {
                $action->handle($table, $ids);
            }

            $table->setResponse(redirect(app('request')->fullUrl()));
        }
    }
}
