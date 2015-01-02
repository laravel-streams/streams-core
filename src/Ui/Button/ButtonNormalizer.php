<?php namespace Anomaly\Streams\Platform\Ui\Button;

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
     * @param array $buttons
     * @return array
     */
    public function normalize(array $buttons)
    {
        foreach ($buttons as &$button) {

            /**
             * If the button is a string then use
             * it as the button parameter.
             */
            if (is_string($button)) {
                $button = [
                    'button' => $button,
                ];
            }

            /**
             * Make sure some default parameters exist.
             */
            $button['attributes'] = array_get($button, 'attributes', []);

            /**
             * All actions use the sm button size.
             */
            $button['size'] = 'sm';
        }

        return $buttons;
    }
}
