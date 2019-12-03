<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ActionBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ActionBuilder
{

    /**
     * Build the actions.
     *
     * @param TableBuilder $builder
     */
    public static function build(TableBuilder $builder)
    {
        $table = $builder->getTable();

        $factory  = app(ActionFactory::class);

        ActionInput::read($builder);

        foreach ($builder->getActions() as $action) {
            if (array_get($action, 'enabled', true)) {
                $table->addAction($factory->make($action));
            }
        }
    }
}
