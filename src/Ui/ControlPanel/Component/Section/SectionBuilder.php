<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionInput;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionFactory;

/**
 * Class SectionBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SectionBuilder
{

    /**
     * Build the sections and push them to the control_panel.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function build(ControlPanelBuilder $builder)
    {
        $controlPanel = $builder->getControlPanel();

        $factory = app(SectionFactory::class);

        SectionInput::read($builder);

        foreach (array_values($builder->getSections()) as $i => $section) {

            if (!authorize(array_get($section, 'permission'))) {
                continue;
            }

            $controlPanel->addSection($section = $factory->make($section));

            /**
             * Merge defaul attributes.
             */
            $section->mergeAttributes([
                'data-keymap' => $i + 1
            ]);
        }
    }
}
