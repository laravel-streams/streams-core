<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Guesser;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class PolicyGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PolicyGuesser
{

    /**
     * Guess the action text.
     *
     * @param TableBuilder $builder
     */
    public static function guess(TableBuilder $builder)
    {
        $actions = $builder->getActions();
        $stream  = $builder->stream;

        if (!$module = app('module.collection')->active()) {
            return;
        }

        $section = cp()->sections->active();

        foreach ($actions as &$action) {

            /*
             * Nothing to do if set already.
             */
            if (isset($action['ability'])) {
                continue;
            }

            /*
             * Try and guess the ability.
             */
            if ($stream) {
                $action['ability'] = $module->getNamespace($stream->slug . '.' . $action['slug']);
            } elseif ($section) {
                $action['ability'] = $module->getNamespace($section->getSlug() . '.' . $action['slug']);
            }
        }

        $builder->setActions($actions);
    }
}
