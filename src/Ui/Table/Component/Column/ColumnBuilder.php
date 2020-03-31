<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ColumnBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ColumnBuilder
{

    /**
     * Build the columns.
     *
     * @param  TableBuilder     $builder
     * @param                   $entry
     * @return ColumnCollection
     */
    public static function build(TableBuilder $builder, $entry)
    {
        $table = $builder->getTable();

        $factory = app(ColumnFactory::class);

        $columns = new ColumnCollection();

        ColumnInput::read($builder);

        foreach ($builder->getColumns() as $column) {

            array_set($column, 'entry', $entry);

            $column = evaluate($column, compact('entry', 'table'));

            $column['value'] = valuate($column, $entry);

            $columns->push($factory->make(translate($column)));
        }

        return $columns;
    }
}
