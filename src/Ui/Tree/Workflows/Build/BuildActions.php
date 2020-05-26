<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Anomaly\Streams\Platform\Ui\Tree\Component\Action\ActionBuilder;

/**
 * Class BuildActions
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildActions
{

    /**
     * Handle the step.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if ($builder->actions === false) {
            return;
        }

        ActionBuilder::build($builder);
    }
}
