<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

/**
 * Class ActionInterpreter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Action
 */
class ActionInterpreter
{

    /**
     * Standardize action input.
     *
     * @param $key
     * @param $parameters
     * @return array
     */
    public function standardize($key, $parameters)
    {
        /**
         * If the key is numeric and the action is
         * a string then treat the string as both the
         * action and the slug. This is OK as long as
         * there are not multiple instances of this
         * input using the same action which is not likely.
         */
        if (is_numeric($key) && is_string($parameters)) {
            $parameters = [
                'slug'   => $parameters,
                'action' => $parameters,
            ];
        }

        /**
         * If the key is not numeric and the action is an
         * array without an action then use the key for
         * the action.
         */
        if (is_array($parameters) && !isset($parameters['action']) && !is_numeric($key)) {
            $parameters['action'] = $key;
        }

        /**
         * If the action is an array and action is not set
         * but the slug is.. use the slug as the action.
         */
        if (is_array($parameters) && !isset($parameters['action']) && isset($parameters['slug'])) {
            $parameters['action'] = $parameters['slug'];
        }

        /**
         * If the action is an array and a slug is not set
         * but the action is.. use the action as the slug.
         */
        if (is_array($parameters) && !isset($parameters['slug']) && isset($parameters['action'])) {
            $parameters['slug'] = $parameters['action'];
        }

        return $parameters;
    }
}
