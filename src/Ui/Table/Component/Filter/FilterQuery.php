<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FilterQuery
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter
 */
class FilterQuery
{

    /**
     * Modify the table's query using the filters.
     *
     * @param Table           $table
     * @param Builder         $query
     * @param FilterInterface $filter
     * @return mixed
     */
    public function filter(Table $table, Builder $query, FilterInterface $filter)
    {
        $handler = $filter->getHandler();

        /**
         * If the handler is a callable string or Closure
         * then call it using the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            return app()->call($handler, compact('table', 'query', 'filter'));
        }
    }
}
