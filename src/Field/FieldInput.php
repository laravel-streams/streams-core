<?php

namespace Anomaly\Streams\Platform\Field;

/**
 * Class FieldInput
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldInput
{

    /**
     * Build the fields.
     *
     * @param array $fields
     * @return array
     */
    public static function read(array $fields)
    {
        foreach ($fields as $handle => &$field) {

            if (is_string($field)) {
                $field = [
                    'type' => $field,
                ];
            }

            if (!isset($field['handle'])) {
                $field['handle'] = $handle;
            }
        }

        return $fields;
    }
}
