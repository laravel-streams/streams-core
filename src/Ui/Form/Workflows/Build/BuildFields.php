<?php

namespace Anomaly\Streams\Platform\Ui\Form\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldCollection;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Workflows\FieldsWorkflow;

/**
 * Class BuildFields
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildFields
{

    /**
     * Handle the step.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if ($builder->fields === false) {
            return;
        }
        
        (new FieldsWorkflow)->process([
            'builder' => $builder,
            'component' => 'fields',
        ]);
    }
}
