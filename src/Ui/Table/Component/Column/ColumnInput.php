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
        $columns = $builder->getButtons();

        /**
         * Resolve & Evaluate
         */
        $columns = resolver($columns, compact('builder'));

        $columns = $columns ?: $builder->getButtons();

        $columns = evaluate($columns, compact('builder'));

        $builder->setButtons($columns);

        // ---------------------------------
        $columns = $builder->getButtons();

        $columns = TableNormalizer::columns($columns);
        $columns = TableNormalizer::attributes($columns);
        $columns = TableNormalizer::dropdowns($columns);

        $builder->setButtons($columns);
        // ---------------------------------

        $builder->setButtons(translate($builder->getButtons()));
    }
}
