<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class EnabledGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EnabledGuesser
{

    /**
     * Guess the enabled property.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guess(ControlPanelBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as &$button) {

            if (!isset($button['enabled']) || is_bool($button['enabled'])) {
                continue;
            }

            /**
             * This is handy for looking at query string input
             * and toggling buttons on and off if there is a value.
             */
            if (is_string($button['enabled']) && is_numeric($button['enabled'])) {
                $button['enabled'] = true;
            }

            /**
             * This is handy for looking at the URI path
             * and toggling buttons on and off if matching.
             */
            if (is_string($button['enabled'])) {
                $button['enabled'] = str_is($button['enabled'], request()->path());
            }
        }

        $builder->setButtons($buttons);
    }
}
