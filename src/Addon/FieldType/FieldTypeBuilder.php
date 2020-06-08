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

        if (!strpos($type, '.')) {

            $addon = app(FieldTypeCollection::class)->first(function ($item) use ($type) {
                return str_is('*.field_type.' . $type, $item['namespace']);
            });

            if (!$addon) {
                return app($type);
            }

            $type = $addon['namespace'];
        }

        return clone (app($type));
    }
}
