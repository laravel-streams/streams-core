<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button;

use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ButtonBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonBuilder
{

    /**
     * Build the buttons.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function build(ControlPanelBuilder $builder)
    {
        $controlPanel = $builder->getControlPanel();

        $factory = app(ButtonFactory::class);

        ButtonInput::read($builder);

        foreach ($builder->getButtons() as $button) {
            if (($button = $factory->make($button)) && $button->enabled) {
                $controlPanel->addButton($button);
            }
        }
    }
}
