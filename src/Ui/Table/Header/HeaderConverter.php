<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

/**
 * Class HeaderConverter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Header
 */
class HeaderConverter
{

    /**
     * Return standardized parameter input.
     *
     * @param $parameters
     * @return array
     */
    public function standardize($parameters)
    {

        /**
         * If the parameters is just a string then
         * use it as the text parameter.
         */
        if (is_string($parameters)) {
            $parameters = ['text' => $parameters];
        }

        return $parameters;
    }
}
