<?php

namespace Anomaly\Streams\Platform\Ui\Form\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Button\Workflows\ButtonsWorkflow;

/**
 * Class BuildButtons
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildButtons
{

    /**
     * Handle the step.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if ($builder->buttons === false) {
            return;
        }

        (new ButtonsWorkflow)->process([
            'builder' => $builder,
            'component' => 'buttons',
        ]);
    }
}
