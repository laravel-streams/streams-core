<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Workflows\Query;

use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;

/**
 * Class StartQuery
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StartQuery
{

    /**
     * Handle the step.
     * 
     * @param GridBuilder $builder
     */
    public function handle(GridBuilder $builder)
    {
        $builder->criteria = $builder->repository->newCriteria();
    }
}
