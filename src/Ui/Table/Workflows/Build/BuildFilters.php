<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Workflows\FiltersWorkflow;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterBuilder;

/**
 * Class BuildFilters
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildFilters
{

    /**
     * Handle the step.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if ($builder->filters === false) {
            return;
        }

        (new FiltersWorkflow)->process([
            'builder' => $builder,
            'component' => 'filters',
        ]);

        dd('Done');
    }
}
