<?php namespace Anomaly\Streams\Platform\Ui\Table\Contract;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Interface TableModelInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Contract
 */
interface TableModelInterface
{

    /**
     * Get the table entries.
     *
     * @param  TableBuilder $builder
     * @return mixed
     */
    public function getTableEntries(TableBuilder $builder);
}
