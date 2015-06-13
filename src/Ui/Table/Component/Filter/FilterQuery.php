<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
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
     * @param TableBuilder    $builder
     * @param Builder         $query
     * @param FilterInterface $filter
     * @return mixed
     */
    public function filter(TableBuilder $builder, Builder $query, FilterInterface $filter)
    {
        if ($filter instanceof SelfHandling) {
            $handler = get_class($filter) . '@handle';
        } else {
            $handler = $filter->getHandler();
        }

        /**
         * If the handler is a callable string or Closure
         * then call it using the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            return app()->call($handler, compact('builder', 'query', 'filter'));
        }
    }
}
