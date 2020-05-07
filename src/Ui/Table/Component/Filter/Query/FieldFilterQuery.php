<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FieldFilterQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FieldFilterQuery
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
        $stream = $filter->stream;

        $fieldType = $stream->fields->{$filter->field}->type();

        $fieldTypeQuery = $fieldType->query;

        App::call([$fieldTypeQuery, 'filter'], compact('query', 'filter', 'builder'));
    }
}
