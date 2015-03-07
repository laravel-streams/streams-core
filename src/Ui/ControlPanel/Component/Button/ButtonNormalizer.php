<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ButtonNormalizer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Button
 */
class ButtonNormalizer
{

    /**
     * Normalize button input.
     *
     * @param ControlPanelBuilder $builder
     */
    public function normalize(ControlPanelBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as $key => &$button) {

            /**
             * If the button is a string but the key
             * is numeric then use the button as the
             * button type.
             */
            if (is_numeric($key) && is_string($button)) {
                $button = [
                    'button' => $button
                ];
            }

            /**
             * If the button AND key are strings then
             * use the key as the button and the
             * button as the text parameters.
             */
            if (!is_numeric($key) && is_string($button)) {
                $button = [
                    'text'   => $button,
                    'button' => $key,
                ];
            }

            /**
             * Make sure some default parameters exist.
             */
            $button['attributes'] = array_get($button, 'attributes', []);

            /**
             * Move the HREF if any to the attributes.
             */
            if (isset($button['href'])) {
                array_set($button['attributes'], 'href', array_pull($button, 'href'));
            }

            /**
             * Move the target if any to the attributes.
             */
            if (isset($button['target'])) {
                array_set($button['attributes'], 'target', array_pull($button, 'target'));
            }

            /**
             * Make sure the HREF is absolute.
             */
            if (
                isset($button['attributes']['href']) &&
                is_string($button['attributes']['href']) &&
                !starts_with($button['attributes']['href'], 'http')
            ) {
                $button['attributes']['href'] = url($button['attributes']['href']);
            }
        }

        $builder->setButtons($buttons);
    }
}
