<?php namespace Anomaly\Streams\Plattable\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract\ActionHandlerInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class ActionExecutor
 *
 * @link          http://anomaly.is/streams-plattable
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Plattable\Ui\Table\Component\Action
 */
class ActionExecutor
{

    /**
     * Execute an action.
     *
     * @param Table $table
     * @param       $handler
     * @throws \Exception
     * @return
     */
    public function execute(Table $table, $handler)
    {
        /**
         * If the handler is a callable string or Closure
         * then call it using the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            return app()->call($handler, compact('table'));
        }

        /**
         * If the handle is an instance of ActionHandlerInterface
         * simply call the handle method on it.
         */
        if ($handler instanceof ActionHandlerInterface) {
            return $handler->handle($table);
        }

        throw new \Exception('Action $handler must be a callable string, Closure or ActionHandlerInterface.');
    }
}
