<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

/**
 * Class FilterConverter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Filter
 */
class FilterConverter
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
         * If the key is numeric and the parameter is
         * a string then assume the parameter is a field
         * type and that the parameter is the field slug.
         */
        if (is_numeric($key) && is_string($parameters)) {
            $parameters = [
                'slug'   => $parameters,
                'field'  => $parameters,
                'filter' => 'field',
            ];
        }

        /**
         * If the key is NOT numeric and the parameter is a
         * string then use the key as the slug and the
         * parameter as the filter.
         */
        if (!is_numeric($key) && is_string($parameters)) {
            $parameters = [
                'slug'   => $key,
                'filter' => $parameters,
            ];
        }

        /**
         * If the key is not numeric and the parameter is an
         * array without a slug then use the key for
         * the slug for the filter.
         */
        if (is_array($parameters) && !isset($parameters['slug']) && !is_numeric($key)) {
            $parameters['slug'] = $key;
        }

        return $parameters;
    }
}
