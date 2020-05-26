<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Workflows\Query;

use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

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
     * @param TreeBuilder $builder
     */
    public function handle(TreeBuilder $builder)
    {

        /**
         * @todo This terminology and parameters need reviewed/revisited.
         */
        if ($builder->tree->options->get('paginate', true)) {

            $builder->tree->pagination = $builder->criteria->paginate([
                'page_name' => $builder->tree->options->get('prefix') . 'page',
                'limit_name' => $builder->tree->options->get('limit') . 'limit',
            ]);

            $builder->tree->entries = $builder->tree->pagination->getCollection();
        }
    }
}
