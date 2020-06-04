<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Row\Workflows\Rows;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\Support\Value;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ValuateRows
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ValuateRows
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $builder->instance->rows->each(function ($row) {
            
            foreach ($row->columns as &$column) {
                $column->value = Value::make($column->getAttributes(), $row->entry);
            }

            foreach ($row->buttons as &$button) {
                $button->fill(Arr::parse($button->getAttributes(), [
                    'entry' => $row->entry,
                ]));
            }
        });
    }
}
