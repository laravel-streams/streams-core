<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Builder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter;

/**
 * Class SearchFilterQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SearchFilterQuery
{

    /**
     * Handle the filter.
     *
     * @param Builder $query
     * @param Filter $filter
     */
    public function handle(Builder $query, TableBuilder $builder, Filter $filter)
    {
        $stream = $filter->stream;

        $query->where(
            function (Builder $query) use ($filter, $stream, $builder) {

                /* @var Builder|HasAttributes $query */
                $casts = $query
                    ->getModel()
                    ->getCasts();

                foreach ($filter->columns as $column) {

                    $value = $filter->getValue();

                    if (Arr::get($casts, $column) == 'json') {
                        $value = addslashes(substr(json_encode($value), 1, -1));
                    }

                    $query->orWhere($column, 'LIKE', "%{$value}%");
                }

                foreach ($filter->fields as $field) {

                    $filter->field = $field;

                    $fieldType      = $stream->fields->get($field)->type();
                    $fieldTypeQuery = $fieldType->query;

                    $fieldTypeQuery->setConstraint('or');

                    App::call($fieldTypeQuery, compact('query', 'filter', 'builder', 'stream'), 'filter');
                }
            }
        );
    }
}
