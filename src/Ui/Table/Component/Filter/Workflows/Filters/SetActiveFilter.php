<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Workflows\Filters;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

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
