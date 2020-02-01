<?php

namespace Anomaly\Streams\Platform\Field;

/**
 * Class FieldBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldBuilder
{

    /**
     * Build the fields.
     *
     * @param array $fields
     * @return FieldCollection
     */
    public static function build(array $fields)
    {
        $fields = FieldInput::read($fields);
        $fields = FieldFactory::make($fields);

        return $fields;
    }
}
