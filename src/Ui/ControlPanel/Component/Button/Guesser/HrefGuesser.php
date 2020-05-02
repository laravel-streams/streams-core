<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser;

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
     * Guess the HREF for a button.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guess(ControlPanelBuilder $builder)
    {
        $buttons  = $builder->getButtons();
        $sections = $builder->getControlPanelSections();

        $active = $sections->active();
        $module = app('module.collection')->active();

        foreach ($buttons as &$button) {

            // If we already have an HREF then skip it.
            if (isset($button['attributes']['href'])) {
                continue;
            }

            // Determine the HREF based on the button type.
            switch (array_get($button, 'button')) {

                case 'add':
                case 'new':
                case 'create':
                    $button['attributes']['href'] = $active->href('create');
                    break;

                case 'export':
                    if ($module) {
                        $button['attributes']['href'] = url(
                            'entry/handle/export/' . $module->getNamespace() . '/' . array_get(
                                $button,
                                'namespace'
                            ) . '/' . array_get($button, 'stream')
                        );
                    }
                    break;
            }

            $type = array_get($button, 'segment', array_get($button, 'button'));

            if (!isset($button['attributes']['href']) && $type) {
                $button['attributes']['href'] = $active->href($type);
            }
        }

        $builder->setButtons($buttons);
    }
}
