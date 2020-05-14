<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class SetActiveAction
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetActiveAction
{

    /**
     * Set the active action.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $prefix  = $builder->table->getOption('prefix');
        $actions = $builder->table->getActions();

        if ($action = $actions->get(app('request')->get($prefix . 'action'))) {
            $action->setActive(true);
        }
    }
}
