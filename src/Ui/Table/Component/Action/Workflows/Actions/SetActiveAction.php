<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Workflows\Actions;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class SetActiveAction
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetActiveAction
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if ($builder->instance->actions->active()) {
            return;
        }

        if ($action = $builder->instance->actions->get($builder->request('action'))) {
            $action->active = true;
        }
    }
}
