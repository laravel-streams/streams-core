<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Workflows\Actions;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class DefaultActions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DefaultActions
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if (!$builder->actions) {
            $builder->actions = [
                'delete',
                'edit',
                'export',
            ];
        }
    }
}
