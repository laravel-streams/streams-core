<?php namespace Anomaly\Streams\Plattable\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterHandlerInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FilterQuery
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Plattable\Ui\Table\Component\Filter
 */
class FilterQuery
{

    /**
     * Modify the table's query using the filters.
     *
     * @param Table           $table
     * @param Builder         $query
     * @param FilterInterface $filter
     * @param                 $handler
     * @return mixed
     * @throws \Exception
     */
    public function filter(Table $table, Builder $query, FilterInterface $filter, $handler)
    {
        /**
         * If the handler is a callable string or Closure
         * then call it using the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            return app()->call($handler, compact('table', 'query', 'filter'));
        }

        /**
         * If the handle is an instance of FilterHandlerInterface
         * simply call the handle method on it.
         */
        if ($handler instanceof FilterHandlerInterface) {
            return $handler->handle($table, $query, $filter);
        }

        throw new \Exception('Filter $handler must be a callable string, Closure or FilterHandlerInterface.');
    }
}
