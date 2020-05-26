<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;
use Anomaly\Streams\Platform\Ui\Grid\Component\Item\ItemBuilder;

/**
 * Class BuildItems
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildItems
{

    /**
     * Handle the step.
     * 
     * @param GridBuilder $builder
     */
    public function handle(GridBuilder $builder)
    {
        if ($builder->grid->entries->isEmpty()) {
            return;
        }

        app(ItemBuilder::class)->build($builder);
    }
}
