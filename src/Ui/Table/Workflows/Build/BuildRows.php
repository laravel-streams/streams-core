<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\Workflows\RowsWorkflow;

/**
 * Class BuildRows
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildRows
{

    /**
     * Handle the step.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if (!$builder->table->entries) {
            return;
        }

        if ($builder->table->entries->isEmpty()) {
            return;
        }

        (new RowsWorkflow())->process([
            'builder' => $builder,
            'component' => 'rows',
        ]);
    }
}
