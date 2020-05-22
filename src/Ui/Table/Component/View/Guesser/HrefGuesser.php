<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Guesser;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HrefGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HrefGuesser
{

    /**
     * Guess the HREF for the views.
     *
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        $views = $builder->views;

        foreach ($views as &$view) {

            // Only automate it if not set.
            if (!isset($view['attributes']['href'])) {
                $view['attributes']['href'] = url(
                    request()->path() . '?' . array_get($view, 'prefix') . 'view=' . $view['slug']
                );
            }
        }

        $builder->views = $views;
    }
}
