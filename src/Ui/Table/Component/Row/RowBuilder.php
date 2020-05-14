<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Row;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\RowFactory;
use Anomaly\Streams\Platform\Ui\Table\Component\Button\ButtonBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnBuilder;

/**
 * Class RowBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class RowBuilder
{

    /**
     * Build the rows.
     *
     * @param TableBuilder $builder
     */
    public static function build(TableBuilder $builder)
    {
        $factory = app(RowFactory::class);

        foreach ($builder->getTableEntries() as $i => $entry) {

            $columns = ColumnBuilder::build($builder, $entry);
            $buttons = ButtonBuilder::build($builder, $entry);

            $buttons = $buttons->whereIn('enabled', [true, null]);

            $class = $builder->getOption('row_class');

            $row = compact('columns', 'buttons', 'entry', 'class');

            $row['key'] = data_get(
                $entry,
                $builder->getOption('row_key', 'id')
            );

            $row['table'] = $builder->getTable();

            $row = evaluate($row, compact('builder', 'entry'));

            $builder->addTableRow($row = $factory->make($row));
        }
    }
}
