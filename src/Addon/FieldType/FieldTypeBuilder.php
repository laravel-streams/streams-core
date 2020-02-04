<?php

namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;

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

        $instance = app($type);

        return $instance;
    }
}
