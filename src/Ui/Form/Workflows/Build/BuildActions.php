<?php

namespace Anomaly\Streams\Platform\Ui\Form\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Workflows\ActionsWorkflow;

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

        (new ActionsWorkflow)->process([
            'builder' => $builder,
            'component' => 'actions',
        ]);
    }
}
