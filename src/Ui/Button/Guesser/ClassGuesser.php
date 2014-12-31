<?php namespace Anomaly\Streams\Platform\Ui\Button\Guesser;

/**
 * Class ClassGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Button\Guesser
 */
class ClassGuesser
{

    /**
     * Guess the class of button.
     *
     * @param array $button
     * @return array
     */
    public function guess(array $button)
    {
        /**
         * If the class is already set then skip it.
         */
        if (array_key_exists('class', $button['attributes'])) {
            return $button;
        }

        /**
         * If the button type is not set then skip it.
         */
        if (!array_key_exists('type', $button)) {
            return $button;
        }

        /**
         * Guess the button class based
         * on the button type.
         */
        $button['attributes']['class'] = 'btn btn-' . $button['type'] . ' btn-sm';

        return $button;
    }
}
