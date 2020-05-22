<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter;
use Anomaly\Streams\Platform\Criteria\Contract\CriteriaInterface;

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
     * @param TableBuilder $builder
     * @param CriteriaInterface $criteria
     */
    public function handle(TableBuilder $builder, Filter $filter)
    {
        $builder->criteria->where($filter->column ?: $filter->slug, 'LIKE', '%' . $filter->getValue() . '%');
    }
}
