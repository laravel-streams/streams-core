<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Workflows\Columns;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class DefaultColumns
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DefaultColumns
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if (!$builder->columns) {
            $builder->columns = [
                'id',
            ];
        }
    }
}
