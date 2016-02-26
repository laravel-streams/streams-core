<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class FieldTypeCollection
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeCollection extends AddonCollection
{

    /**
     * Get a field type from the
     * collection by namespace key.
     *
     * @param  mixed $key
     * @param  mixed $default
     * @return null|FieldType
     */
    public function get($key, $default = null)
    {
        $type = parent::get($key, $default);

        if (!$type) {
            return null;
        }

        return clone($type);
    }
}
