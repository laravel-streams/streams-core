<?php namespace Anomaly\Streams\Platform\Ui\Form\Button;

use Anomaly\Streams\Platform\Ui\Icon\IconReader;

/**
 * Class ButtonReader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Button
 */
class ButtonReader
{

    /**
     * Read and convert minimal button input.
     *
     * @param $key
     * @param $value
     */
    public function convert($key, $value)
    {
        /**
         * If the key is numeric and the value
         * is a string then the value is the button.
         */
        if (is_numeric($key) and is_string($value)) {

            $value = [
                'button' => $value,
            ];
        }

        /**
         * If the key is NOT numeric and the value is
         * a string then the value becomes the text and
         * the key is the button.
         */
        if (!is_numeric($key) and is_string($value)) {

            $value = [
                'button' => $key,
                'text'   => $value,
            ];
        }

        /**
         * If the key is a string and the value is an
         * array without a button then the key is the button.
         */
        if (is_array($value) and !isset($value['button']) and !is_numeric($key)) {

            $value['button'] = $key;
        }

        return $value;
    }
}
 