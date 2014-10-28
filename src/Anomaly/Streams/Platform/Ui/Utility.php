<?php namespace Anomaly\Streams\Platform\Ui;

/**
 * Class Utility
 *
 * This is the base utility class for the various UIs.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class Utility
{

    /**
     * Return an array parsed into a string of attributes.
     *
     * @param $attributes
     * @return string
     */
    public function attributes($attributes)
    {
        return implode(
            ' ',
            array_map(
                function ($v, $k) {

                    return $k . '=' . '"' . trans($v) . '"';

                },
                $attributes,
                array_keys($attributes)
            )
        );
    }

}
 