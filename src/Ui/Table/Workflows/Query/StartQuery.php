<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Query;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

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
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $builder->criteria = $builder->repository->newCriteria();
    }
}
