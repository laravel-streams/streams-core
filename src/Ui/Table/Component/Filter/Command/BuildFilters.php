<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class BuildFilters
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildFilters
{

    /**
     * Handle the command.
     *
     * @param TableBuilder $builder
     * @param FilterBuilder $filters
     */
    public function handle(TableBuilder $builder, FilterBuilder $filters)
    {
        $filters->build($builder);
    }
}
