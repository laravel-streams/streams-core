<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

/**
 * Class ActionReader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action
 */
class ActionReader
{

    /**
     * Read and convert action input.
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
                'slug'   => $value,
                'action' => $value,
            ];
        }

        /**
         * If the slug is a string and the value is a
         * string then use the slug as is and the
         * actions as the action.
         */
        if (!is_numeric($key) and is_string($value)) {

            $value = [
                'slug'   => $key,
                'action' => $value,
            ];
        }

        /**
         * If the slug is a string and the value is an
         * array without a slug then add the slug.
         */
        if (is_array($value) and !isset($value['slug']) and !is_numeric($key)) {

            $value['slug'] = $key;
        }

        return $value;
    }
}
 