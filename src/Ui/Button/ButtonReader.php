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
         * Make sure the attributes array is set.
         */
        $button['attributes'] = array_get($button, 'attributes', []);

        /**
         * If the URL is present outside of the attributes
         * then pull it and put it in the attributes array.
         */
        if (isset($button['url'])) {
            $button['attributes']['url'] = array_pull($button, 'url');
        }

        return $button;
    }
}
