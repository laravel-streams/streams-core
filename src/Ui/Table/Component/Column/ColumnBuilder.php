<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\Workflows\Build\BuildWorkflow;

/**
 * Class ColumnBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ColumnBuilder extends Builder
{

    /**
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'component' => 'column',

        'column' => Column::class,

        'build_workflow' => BuildWorkflow::class,
    ];

    /**
     * Build the columns.
     *
     * @param  TableBuilder     $builder
     * @param                   $entry
     * @return ColumnCollection
     */
    public static function build(TableBuilder $builder, $entry)
    {
        $factory = app(ColumnFactory::class);

        $columns = new ColumnCollection();

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
