<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Workflows\Views;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class DefaultViews
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DefaultViews
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if (!$stream = $builder->stream) {
            return;
        }

        //if ($stream->trashable && !$builder->views && !$builder->async) {
        $builder->views = [
            'all',
            'trash',
        ];
        //}
    }
}
