<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Actions;

use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;

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
