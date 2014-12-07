<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

/**
 * Class ActionReader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Action
 */
class ActionReader
{

    /**
     * Convert and read action input.
     *
     * @param $key
     * @param $value
     * @return array
     */
    public function convert($key, $value)
    {
        /**
         * If the key is numeric and the value is
         * a string then treat the string as both the
         * value and the slug. This is OK as long as
         * there are not multiple instances of this
         * input using the same value which is not likely.
         */
        if (is_numeric($key) and is_string($value)) {

            $value = [
                'action' => $value,
            ];
        }

        /**
         * If the key is not numeric and the value is an
         * array without an value then use the key for
         * the action.
         */
        if (is_array($value) and !isset($value['action']) and !is_numeric($key)) {

            $value['action'] = $key;
        }

        /**
         * If the value is an array and value is not set
         * but the slug is.. use the slug as the action.
         */
        if (is_array($value) and !isset($value['action']) and isset($value['slug'])) {

            $value['action'] = $value['slug'];
        }

        return $value;
    }
}
 