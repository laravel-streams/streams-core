<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Filters;

use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterHandler;

/**
 * Class SetActiveFilter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetActiveFilter
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if ($builder->instance->filters->active()) {
            return;
        }

        if ($filter = $builder->instance->filters->get($builder->request('filter'))) {
            $filter->active = true;
        }
    }
}
