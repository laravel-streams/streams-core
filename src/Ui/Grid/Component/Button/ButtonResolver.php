<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Component\Button;

use Anomaly\Streams\Platform\Support\Facades\Resolver;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;

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
     * Resolve grid views.
     *
     * @param GridBuilder $builder
     */
    public function resolve(GridBuilder $builder)
    {
        Resolver::resolve($builder->buttons, compact('builder'));
    }
}
