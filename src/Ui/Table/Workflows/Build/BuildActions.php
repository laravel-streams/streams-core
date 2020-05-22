<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\ExecuteAction;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\SetActiveAction;

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
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if ($builder->actions === false) {
            return;
        }

        ActionBuilder::build($builder);

        dispatch_now(new SetActiveAction($builder));
    }
}