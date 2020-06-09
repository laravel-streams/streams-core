<?php

namespace Anomaly\Streams\Platform\Addon\FieldType;

/**
 * Class FieldTypeBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FieldTypeBuilder
{

    /**
     * Build a field type.
     *
     * @param  array $parameters
     * @return FieldType
     */
    public static function build($type)
    {
        if (is_array($type)) {
            $type = $type['type'];
        }

        return clone (app($type));
    }
}
