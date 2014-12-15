<?php namespace Anomaly\Streams\Platform\Ui\Table\Contract;

use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Interface TableModelInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Contract
 */
interface TableModelInterface
{

    /**
     * Get the table entries.
     *
     * @param Table $table
     * @return mixed
     */
    public function getTableEntries(Table $table);
}
