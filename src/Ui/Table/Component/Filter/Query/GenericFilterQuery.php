<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query;

use Anomaly\Streams\Platform\Criteria\Contract\CriteriaInterface;
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
     * @param Filter $filter
     * @param CriteriaInterface $criteria
     */
    public function handle(Filter $filter, CriteriaInterface $criteria)
    {
        $criteria->where($filter->column ?: $filter->slug, 'LIKE', '%' . $filter->getValue() . '%');
    }
}
