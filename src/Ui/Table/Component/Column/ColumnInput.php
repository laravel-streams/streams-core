<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableNormalizer;

/**
 * Class ColumnInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ColumnInput
{

    /**
     * Read the builder's column input.
     *
     * @param TableBuilder $builder
     */
    public function read(TableBuilder $builder)
    {
        $columns = $builder->getColumns();

        /**
         * Resolve & Evaluate
         */
        $columns = resolver($columns, compact('builder'));

        $columns = $columns ?: $builder->getColumns();

        $columns = evaluate($columns, compact('builder'));

        $builder->setColumns($columns);

        // ---------------------------------
        $columns = $builder->getColumns();

        $columns = TableNormalizer::columns($columns);
        $columns = TableNormalizer::attributes($columns);
        $columns = TableNormalizer::dropdowns($columns);

        $builder->setColumns($columns);
        // ---------------------------------

        $builder->setColumns(translate($builder->getColumns()));
    }
}
