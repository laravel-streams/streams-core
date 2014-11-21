<?php namespace Anomaly\Streams\Platform\Addon\FieldType\Contract;

/**
 * Interface SetterFieldTypeInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType\Contract
 */
interface SetterFieldTypeInterface
{

    /**
     * Set the model attributes for it.
     *
     * @param array $attributes
     * @param       $value
     * @return mixed
     */
    public function setAttribute(array &$attributes, $value);
}
 