<?php namespace Anomaly\Streams\Platform\Ui\Grid\Contract;

use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;
use Illuminate\Support\Collection;

/**
 * Interface GridRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Grid\Contract
 */
interface GridRepositoryInterface
{

    /**
     * Get the grid entries.
     *
     * @param GridBuilder $builder
     * @return Collection
     */
    public function get(GridBuilder $builder);

    /**
     * Save the grid.
     *
     * @param GridBuilder $builder
     * @param array       $items
     */
    public function save(GridBuilder $builder, array $items = []);
}
