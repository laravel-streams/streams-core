<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Segment;

use Anomaly\Streams\Platform\Support\Facades\Resolver;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class SegmentResolver
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SegmentResolver
{

    /**
     * Resolve tree views.
     *
     * @param TreeBuilder $builder
     */
    public function resolve(TreeBuilder $builder)
    {
        Resolver::resolve($builder->getSegments(), compact('builder'));
    }
}
