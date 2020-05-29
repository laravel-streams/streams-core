<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnProcessor;

/**
 * Class ProcessInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ProcessInput
{

    public function handle(Builder $builder)
    {
        //$factory = app(ColumnFactory::class);

        //$columns = new ColumnCollection();

        (new ColumnProcessor([
            'parent' => $builder
        ]));

        dd($builder->columns);

        ColumnInput::read($builder);

        foreach ($builder->columns as $column) {

            array_set($column, 'entry', $entry);

            $column = evaluate($column, compact('entry', 'builder'));

            $column['value'] = valuate($column, $entry);

            $columns->push($factory->make(translate($column)));
        }

        return $columns;
    }
}
