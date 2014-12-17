<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

/**
 * Class ViewConverter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\View
 */
class ViewConverter
{

    /**
     * Return standardized parameter input.
     *
     * @param $key
     * @param $parameters
     * @return array
     */
    public function standardize($key, $parameters)
    {

        /**
         * If the key is numeric and the parameters is
         * a string then treat the string as both the
         * parameters and the slug. This is OK as long as
         * there are not multiple instances of this
         * input using the same parameters which is not likely.
         */
        if (is_numeric($key) && is_string($parameters)) {
            $parameters = [
                'slug' => $parameters,
                'view' => $parameters,
            ];
        }

        /**
         * If the key is NOT numeric and the parameters is a
         * string then use the key as the slug and the
         * parameters as the view.
         */
        if (!is_numeric($key) && is_string($parameters)) {
            $parameters = [
                'slug' => $key,
                'view' => $parameters,
            ];
        }

        /**
         * If the key is not numeric and the parameters is an
         * array without a slug then use the key for
         * the slug for the view.
         */
        if (is_array($parameters) && !isset($parameters['slug']) && !is_numeric($key)) {
            $parameters['slug'] = $key;
        }

        return $parameters;
    }
}
