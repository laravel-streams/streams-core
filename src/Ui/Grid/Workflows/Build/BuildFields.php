<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Tree\Component\Field\FieldBuilder;
use Anomaly\Streams\Platform\Ui\Tree\Component\Field\FieldCollection;

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

        if (!$builder->fields) {
            
            $builder->tree->fields = new FieldCollection($builder->stream->fields->all());

            return;
        }
        
        FieldBuilder::build($builder);
    }
}
