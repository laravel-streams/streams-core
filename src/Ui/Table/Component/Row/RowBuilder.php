<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Row;

use Anomaly\Streams\Platform\Ui\Support\Builder;

/**
 * Class RowBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class RowBuilder extends Builder
{

    /**
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'parent' => null,

        'assets' => [],

        'component' => 'row',

        'row' => Row::class,

        'build_workflow' => BuildWorkflow::class,
    ];
}

// $columns = (new ColumnBuilder([
//     'parent' => $builder,
// ]))->build();

// foreach ($builder->table->entries as $i => $entry) {

//     $buttons = ButtonBuilder::build($builder, $entry);

//     // $column = evaluate($column, compact('entry', 'builder'));

//     // $column['value'] = valuate($column, $entry);

//     $buttons = $buttons->whereIn('enabled', [true, null]);

//     $row = compact('columns', 'buttons', 'entry');

//     $row['key'] = data_get($entry, 'id');

//     $row['table'] = $builder->table;

//     $row = evaluate($row, compact('builder', 'entry'));

//     $builder->table->rows->add($row = $factory->make($row));
// }
