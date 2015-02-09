<?php namespace Anomaly\Streams\Platform\Ui\Table\Contract;

use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Support\Collection;

/**
 * Interface TableRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Contract
 */
interface TableRepository
{

    /**
     * Get the table entries.
     *
     * @param Table $table
     * @return Collection
     */
    public function get(Table $table);
}
