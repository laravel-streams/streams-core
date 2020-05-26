<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Anomaly\Streams\Platform\Ui\Tree\Component\Segment\SegmentBuilder;

/**
 * Class BuildSegments
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildSegments
{

    /**
     * Handle the step.
     * 
     * @param TreeBuilder $builder
     */
    public function handle(TreeBuilder $builder)
    {
        if ($builder->tree->entries->isEmpty()) {
            return;
        }

        foreach ($builder->tree->entries as $i => $entry) {
            SegmentBuilder::build($builder, $entry);
        }
    }
}
