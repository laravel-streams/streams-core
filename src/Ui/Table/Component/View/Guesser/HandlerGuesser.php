<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Guesser;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HandlerGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HandlerGuesser
{

    /**
     * Guess the handler for the views.
     *
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        $views = $builder->getViews();

        foreach ($views as &$view) {

            // Only automate it if not set.
            if (!isset($view['handler'])) {

                $class = explode('\\', get_class($builder));

                array_pop($class);

                $class = implode('\\', $class) . '\\View\\' . ucfirst(camel_case($view['slug'])) . 'Handler';

                if (class_exists($class)) {
                    $view['handler'] = $class . '@handle';
                }
            }
        }

        $builder->setViews($views);
    }
}
