<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Guesser;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class QueryGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class QueryGuesser
{

    /**
     * Guess the query handler for the views.
     *
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        $views = $builder->views;

        foreach ($views as &$view) {

            // Only automate it if not set.
            if (!isset($view['query'])) {

                $class = explode('\\', get_class($builder));

                array_pop($class);

                $class = implode('\\', $class) . '\\View\\' . ucfirst(camel_case($view['slug'])) . 'Query';

                if (class_exists($class)) {
                    $view['query'] = $class . '@handle';
                }
            }
        }

        $builder->views = $views;
    }
}
