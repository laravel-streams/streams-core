<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionExecutor;

/**
 * Class ExecuteAction
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExecuteAction
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     * @param ActionExecutor $executor
     */
    public function handle(TableBuilder $builder, ActionExecutor $executor)
    {
        if (!request()->isMethod('post')) {
            return;
        }

        dd('ExecuteAction not implemented yet.');

        $actions = $builder->table->getActions();

        if ($action = $actions->active()) {
            $executor->execute($builder, $action);
        }
    }
}
