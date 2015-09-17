<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Contract;

use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Illuminate\Support\Collection;

/**
 * Interface TreeRepositoryInterface.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Contract
 */
interface TreeRepositoryInterface
{
    /**
     * Get the tree entries.
     *
     * @param TreeBuilder $builder
     * @return Collection
     */
    public function get(TreeBuilder $builder);

    /**
     * Save the tree.
     *
     * @param TreeBuilder $builder
     * @param array       $items
     * @param null        $parent
     */
    public function save(TreeBuilder $builder, array $items = [], $parent = null);
}
