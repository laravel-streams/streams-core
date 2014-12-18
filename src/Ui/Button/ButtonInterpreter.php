<?php namespace Anomaly\Streams\Platform\Ui\Button;

/**
 * Class ButtonInterpreter
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Button
 */
class ButtonInterpreter
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
         * If the key is numeric and the button
         * is a string then the parameters is the button.
         */
        if (is_numeric($key) && is_string($parameters)) {
            $parameters = [
                'button' => $parameters,
            ];
        }

        /**
         * If the key is NOT numeric and the parameters is
         * a string then the parameters becomes the text and
         * the key is the button.
         */
        if (!is_numeric($key) && is_string($parameters)) {
            $parameters = [
                'button' => $key,
                'text'   => $parameters,
            ];
        }

        /**
         * If the key is a string and the parameters is an
         * array without a parameters then the key is the button.
         */
        if (is_array($parameters) && !isset($parameters ['button']) && !is_numeric($key)) {
            $parameters ['button'] = $key;
        }

        /**
         * If the URL is present outside of the attributes
         * then pull it and put it in the attributes.
         */
        if (isset($parameters['url'])) {
            $parameters['attributes']['url'] = array_pull($parameters, 'url');
        }

        return $parameters;
    }
}
