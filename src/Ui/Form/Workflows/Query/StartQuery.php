<?php

namespace Anomaly\Streams\Platform\Ui\Form\Workflows\Query;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class StartQuery
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StartQuery
{

    /**
     * Handle the step.
     * 
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        $builder->criteria = $builder->repository->newCriteria();
    }
}
