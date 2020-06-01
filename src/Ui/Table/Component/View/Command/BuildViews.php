<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class BuildViews
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildViews
{

    /**
     * Handle the command.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        (new ViewBuilder([
            'parent' => $builder,
        ]));

        dispatch_now(new SetActiveView($builder));
    }
}
