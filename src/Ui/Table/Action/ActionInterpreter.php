<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

/**
 * Class ActionInterpreter
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Action
 */
class ActionInterpreter
{

    /**
     * Return standardized parameter input.
     *
     * @param  $key
     * @param  $parameters
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
                'slug'   => $parameters,
                'action' => $parameters,
            ];
        }

        /**
         * If the slug is a string and the parameters is a
         * string then use the slug as is and the
         * actions as the action.
         */
        if (!is_numeric($key) && is_string($parameters)) {
            $parameters = [
                'slug'   => $key,
                'action' => $parameters,
            ];
        }

        /**
         * If the slug is a string and the parameters is an
         * array without a slug then add the slug.
         */
        if (is_array($parameters) && !isset($parameters['slug']) && !is_numeric($key)) {
            $parameters['slug'] = $key;
        }

        return $parameters;
    }
}
