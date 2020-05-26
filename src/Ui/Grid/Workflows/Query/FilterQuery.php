<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Workflows\Query;

use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;

/**
 * Class FilterQuery
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FilterQuery
{

    /**
     * Handle the step.
     * 
     * @param GridBuilder $builder
     */
    public function handle(GridBuilder $builder)
    {
        foreach ($builder->grid->filters->active() as $filter) {

            /*
            * If the handler is a callable string or Closure
            * then call it using the IoC container.
            */
            if (is_string($filter->query) || $filter->query instanceof \Closure) {
                App::call($filter->query, compact('builder', 'filter'), 'handle');
            }
        }
    }
}
