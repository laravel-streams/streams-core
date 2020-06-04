<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Workflows\Fields;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class DefaultFields
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DefaultFields
{

    /**
     * Handle the step.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if ($builder->fields) {
            return;
        }
    
        if ($builder->entry) {
            
            $builder->fields = [
                //'update',
            ];

            return;
        }

        $builder->fields = [
            //'save',
        ];
    }
}
