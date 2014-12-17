<?php namespace Anomaly\Streams\Platform\Ui\Table\Column;

/**
 * Class ColumnConverter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Column
 */
class ColumnConverter
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
         * If the parameters is just a string then treat
         * it as the header AND the value.
         */
        if (is_numeric($key) && is_string($parameters)) {
            $parameters = [
                'header' => $parameters,
                'value'  => $parameters,
            ];
        }

        return $parameters;
    }
}
