<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Workflows\Query;

use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;

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
     * @param GridBuilder $builder
     */
    public function handle(GridBuilder $builder)
    {

        /**
         * @todo This terminology and parameters need reviewed/revisited.
         */
        if ($builder->grid->options->get('paginate', true)) {

            $builder->grid->pagination = $builder->criteria->paginate([
                'page_name' => $builder->grid->options->get('prefix') . 'page',
                'limit_name' => $builder->grid->options->get('limit') . 'limit',
            ]);

            $builder->grid->entries = $builder->grid->pagination->getCollection();
        }
    }
}
