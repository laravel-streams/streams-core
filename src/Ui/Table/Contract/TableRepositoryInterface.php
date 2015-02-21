<?php namespace Anomaly\Streams\Platform\Ui\Table\Contract;

use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Support\Collection;

/**
 * Interface TableRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Contract
 */
interface TableRepositoryInterface
{

    /**
     * Get the table entries.
     *
     * @param Table $table
     * @return Collection
     */
    public function get(Table $table);
}
