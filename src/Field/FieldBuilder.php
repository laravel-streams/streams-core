<?php

namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Stream\Stream;

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
     * @return array
     */
    public static function build(array $fields)
    {
        $fields = FieldInput::read($fields);

        return $fields;
    }
}
