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
    
        /**
         * If no fields are set and this
         * is a streams field - we can just
         * move the fields over and be done.
         */
        if ($builder->entry && $builder->stream) {
            
            $builder->instance->fields = $builder->stream->fields;

            return;
        }
    }
}
