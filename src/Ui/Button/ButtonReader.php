<?php namespace Anomaly\Streams\Platform\Ui\Button;

/**
 * Class ButtonReader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Button
 */
class ButtonReader
{

    /**
     * Standardize button configuration input.
     *
     * @param $button
     * @return array
     */
    public function standardize($button)
    {

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
        $button['size']       = array_get($button, 'size', 'md');

        return $button;
    }
}
