<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class GenericFilterQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GenericFilterQuery
{

    /**
     * Handle the filter.
     *
     * @param Builder $query
     * @param Filter $filter
     * @param TableBuilder $builder
     */
    public function handle(Builder $query, Filter $filter, TableBuilder $builder)
    {
        $stream = $filter->getStream();

        if ($stream && $fieldType = $stream->getFieldType($filter->getField())) {
            $fieldTypeQuery = $fieldType->getQuery();

            App::call([$fieldTypeQuery, 'filter'], compact('query', 'filter', 'builder'));

            return;
        }

        if ($stream && $fieldType = $stream->getFieldType($filter->getSlug())) {
            $fieldTypeQuery = $fieldType->getQuery();

            App::call([$fieldTypeQuery, 'filter'], compact('query', 'filter', 'builder'));

            return;
        }

        if ($filter->isExact()) {
            $query->where($filter->getColumn() ?: $filter->getSlug(), $filter->getValue());
        } else {
            $query->where($filter->getColumn() ?: $filter->getSlug(), 'LIKE', "%{$filter->getValue()}%");
        }
    }
}
