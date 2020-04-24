<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ShortcutBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ShortcutBuilder
{

    /**
     * Build the shortcuts and push them to the control_panel.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function build(ControlPanelBuilder $builder)
    {
        $controlPanel = $builder->getControlPanel();

        $factory = app(ShortcutFactory::class);

        ShortcutInput::read($builder);

        foreach ($builder->getShortcuts() as $shortcut) {

            // @todo revisit 
            // if (!authorize(array_get($shortcut, 'permission'))) {
            //     continue;
            // }

            $controlPanel->addShortcut($factory->make($shortcut));
        }
    }
}
