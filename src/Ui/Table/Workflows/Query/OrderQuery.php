<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Query;

use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class OrderQuery
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class OrderQuery
{

    /**
     * Handle the step.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if (!$value = $builder->request('order_by')) {
            return;
        }

        $builder->criteria->orderBy($value, $builder->request('sort', 'asc'));
    }
}
