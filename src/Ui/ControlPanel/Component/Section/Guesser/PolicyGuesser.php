<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser;

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
     * Guess the sections title.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guess(ControlPanelBuilder $builder)
    {
        if (!$module = app('module.collection')->active()) {
            return;
        }

        $sections = $builder->getSections();

        foreach ($sections as &$section) {

            // If policy is set then skip it.
            if (isset($section['policy'])) {
                continue;
            }

            // @todo revisit will what's a standard non-stream policy path for a custom section?
            // Here? Controller? Validate by config for permissions?
            //$section['policy'] = $module->getNamespace($section['slug'] . '.*');
        }

        $builder->setSections($sections);
    }
}
