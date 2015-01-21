<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

/**
 * Class FieldTypeModifier
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeModifier
{

    /**
     * Modify the value.
     *
     * @param  $value
     * @return mixed
     */
    public function modify($value)
    {
        return $value;
    }

    /**
     * Reverse the above modification.
     *
     * @param  $value
     * @return mixed
     */
    public function reverse($value)
    {
        return $value;
    }
}
