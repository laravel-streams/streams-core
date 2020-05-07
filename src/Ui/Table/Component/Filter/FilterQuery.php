<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FilterQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FilterQuery
{

    /**
     * Modify the table's query using the filters.
     *
     * @param TableBuilder    $builder
     * @param Filter $filter
     * @param Builder         $query
     */
    public function filter(TableBuilder $builder, Filter $filter, Builder $query)
    {

        /**
         * Make sure we're including
         * only distinct results.
         */
        $query->distinct();

        /*
         * If the filter is self handling then let
         * it filter the query itself.
         */
        if (method_exists($filter, 'handle')) {
            App::call([$filter, 'handle'], compact('builder', 'query', 'filter'));

            return;
        }

        $handler = $filter->getQuery();

        // Self handling implies @handle
        if (is_string($handler) && !str_contains($handler, '@')) {
            $handler .= '@handle';
        }

        /*
         * If the handler is a callable string or Closure
         * then call it using the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            App::call($handler, compact('builder', 'query', 'filter'));
        }
    }
}
