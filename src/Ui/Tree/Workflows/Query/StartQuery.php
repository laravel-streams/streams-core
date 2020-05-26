<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Workflows\Query;

use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

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
     * @param TreeBuilder $builder
     */
    public function handle(TreeBuilder $builder)
    {
        $builder->criteria = $builder->repository->newCriteria();
    }
}
