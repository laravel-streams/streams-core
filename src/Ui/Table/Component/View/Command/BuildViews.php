<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Workflows\ViewsWorkflow;

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
        (new ViewsWorkflow)->process([
            'builder' => $builder,
            'component' => 'views',
        ]);

        dd($builder->instance->views);
        // (new ViewBuilder([
        //     'parent' => $builder,
        // ]));

        dispatch_now(new SetActiveView($builder));
    }
}
