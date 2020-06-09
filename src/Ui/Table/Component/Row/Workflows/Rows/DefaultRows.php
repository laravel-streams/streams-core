<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Row\Workflows\Rows;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class DefaultRows
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DefaultRows
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if (!$builder->rows) {
            $builder->rows = $builder->instance->entries->map(function ($entry) use ($builder) {
                return [
                    'key' => data($entry, 'id'),

                    'entry' => $entry,
                    'table' => $builder,

                    'columns' => $builder->instance->columns->map(function ($column) {
                        return clone ($column);
                    }), // Collection
                    'buttons' => $builder->instance->buttons->map(function ($button) {
                        return clone ($button);
                    }), // Collection
                ];
            })->all();
        }
    }
}
