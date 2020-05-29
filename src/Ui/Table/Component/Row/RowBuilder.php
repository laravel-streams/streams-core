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

        foreach ($builder->table->entries as $i => $entry) {

            $columns = (new ColumnBuilder(compact('builder', 'entry')))->build();
            $buttons = ButtonBuilder::build($builder, $entry);

            $buttons = $buttons->whereIn('enabled', [true, null]);

            $row = compact('columns', 'buttons', 'entry');

            $row['key'] = data_get($entry, 'id');

            $row['table'] = $builder->table;

            $row = evaluate($row, compact('builder', 'entry'));

            $builder->table->rows->add($row = $factory->make($row));
        }
    }
}
