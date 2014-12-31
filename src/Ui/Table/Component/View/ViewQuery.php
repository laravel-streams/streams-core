<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Contract\ViewHandlerInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ViewQuery
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View
 */
class ViewQuery
{

    /**
     * Modify the table's query using the views.
     *
     * @param Table   $table
     * @param Builder $query
     * @param         $handler
     * @throws \Exception
     * @return mixed
     */
    public function filter(Table $table, Builder $query, $handler)
    {
        /**
         * If the handler is a callable string or Closure
         * then call it using the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            return app()->call($handler, compact('table', 'query'));
        }

        /**
         * If the handle is an instance of ViewHandlerInterface
         * simply call the handle method on it.
         */
        if ($handler instanceof ViewHandlerInterface) {
            return $handler->handle($table, $query);
        }

        throw new \Exception('View $handler must be a callable string, Closure or ViewHandlerInterface.');
    }
}
