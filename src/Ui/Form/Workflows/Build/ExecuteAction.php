<?php

namespace Anomaly\Streams\Platform\Ui\Form\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionExecutor;

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
     * @param FormBuilder $builder
     * @param ActionExecutor $executor
     */
    public function handle(FormBuilder $builder, ActionExecutor $executor)
    {
        if (!request()->isMethod('post')) {
            return;
        }

        dd('ExecuteAction not implemented yet.');

        $actions = $builder->form->getActions();

        if ($action = $actions->active()) {
            $executor->execute($builder, $action);
        }
    }
}
