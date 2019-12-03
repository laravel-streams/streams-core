<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut\Guesser;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

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
     * Guess the shortcuts HREF attribute.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guess(ControlPanelBuilder $builder)
    {
        if (!$module = app('module.collection')->active()) {
            return;
        }

        $shortcuts = $builder->getShortcuts();

        foreach ($shortcuts as $index => &$shortcut) {

            // If HREF is set then skip it.
            if (isset($shortcut['attributes']['href'])) {
                continue;
            }

            $href = url('admin/' . $module->getSlug());

            if ($index !== 0 && $module->getSlug() !== $shortcut['slug']) {
                $href .= '/' . $shortcut['slug'];
            }

            $shortcut['attributes']['href'] = $href;
        }

        $builder->setShortcuts($shortcuts);
    }
}
