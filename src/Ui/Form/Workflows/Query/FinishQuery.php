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

        /**
         * @todo This terminology and parameters need reviewed/revisited.
         */
        if ($builder->form->options->get('paginate', true)) {

            $builder->form->pagination = $builder->criteria->paginate([
                'page_name' => $builder->form->options->get('prefix') . 'page',
                'limit_name' => $builder->form->options->get('limit') . 'limit',
            ]);

            $builder->form->entries = $builder->form->pagination->getCollection();
        }
    }
}
