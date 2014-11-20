<?php namespace Anomaly\Streams\Platform\Ui;

use Anomaly\Streams\Platform\Traits\DispatchableTrait;

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

    use DispatchableTrait;

    /**
     * Return an array parsed into a string of attributes.
     *
     * @param array $attributes
     * @return string
     */
    public function attributeString(array $attributes)
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
 