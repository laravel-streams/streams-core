<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut\Guesser;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

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
     * Guess the shortcuts title.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guess(ControlPanelBuilder $builder)
    {
        if (!$module = app('module.collection')->active()) {
            return;
        }

        $shortcuts = $builder->getShortcuts();

        foreach ($shortcuts as &$shortcut) {

            // If policy is set then skip it.
            if (isset($shortcut['policy'])) {
                continue;
            }

            // @todo revisit best method to lazily register policies like this
            // And what's the naming standard? Override path?
            //$shortcut['policy'] = $module->getNamespace($shortcut['slug'] . '.*');
        }

        $builder->setShortcuts($shortcuts);
    }
}
