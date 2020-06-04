<?php

namespace Anomaly\Streams\Platform\Ui\Form\Workflows\Query;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FinishQuery
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FinishQuery
{

    /**
     * Handle the step.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        $builder->instance->entry = $builder->criteria->find($builder->entry);
    }
}
