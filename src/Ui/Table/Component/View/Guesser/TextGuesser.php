<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Guesser;

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
     * Guess the text for the views.
     *
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        if (!$module = app('module.collection')->active()) {
            return;
        }

        $views = $builder->views;

        foreach ($views as &$view) {

            // Only automate it if not set.
            if (!isset($view['text'])) {
                $view['text'] = $module->getNamespace('view.' . $view['slug']);
            }
        }

        $builder->views = $views;
    }
}
