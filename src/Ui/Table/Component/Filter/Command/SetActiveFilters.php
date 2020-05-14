<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class SetActiveFilters
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetActiveFilters
{

    /**
     * Handle the command.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        /* @var Filter $filter */
        foreach ($builder->getTableFilters() as $filter) {
            if (app('request')->get($filter->getInputName())) {
                $filter->active = true;
            }
        }
    }
}
