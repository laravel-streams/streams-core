<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class TextGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TextGuesser
{

    /**
     * Guess the action text.
     *
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        $actions = $builder->getActions();

        if (!$module = app('module.collection')->active()) {
            return;
        }

        foreach ($actions as &$action) {

            // Only if it's not already set.
            if (!isset($action['text'])) {
                $action['text'] = $module->getNamespace('button.' . $action['slug']);
            }
        }

        $builder->setActions($actions);
    }
}
