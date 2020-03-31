<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Button;

use Anomaly\Streams\Platform\Support\Facades\Resolver;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class ButtonResolver
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonResolver
{

    /**
     * Resolve tree views.
     *
     * @param TreeBuilder $builder
     */
    public function resolve(TreeBuilder $builder)
    {
        Resolver::resolve($builder->getButtons(), compact('builder'));
    }
}
