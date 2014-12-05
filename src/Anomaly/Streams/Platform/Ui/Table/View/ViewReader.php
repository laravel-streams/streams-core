<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

/**
 * Class ViewReader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\View
 */
class ViewReader
{

    /**
     * Read and convert view input.
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
                'slug' => $value,
                'view' => $value,
            ];
        }

        /**
         * If the key is NOT numeric and the value is a
         * string then use the key as the slug and the
         * value as the view.
         */
        if (!is_numeric($key) and is_string($value)) {

            $value = [
                'slug' => $key,
                'view' => $value,
            ];
        }

        /**
         * If the key is not numeric and the value is an
         * array without a slug then use the key for
         * the slug for the view.
         */
        if (is_array($value) and !isset($value['slug']) and !is_numeric($key)) {

            $value['slug'] = $key;
        }

        return $value;
    }
}
 