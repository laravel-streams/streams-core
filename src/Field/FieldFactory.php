<?php

namespace Streams\Core\Field;

/**
 * Class FieldFactory
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldFactory
{

    /**
     * Build the fields.
     *
     * @param array $fields
     * @return FieldCollection
     */
    public static function make(array $fields)
    {
        $collection = new FieldCollection();

        foreach ($fields as $field) {

            $field = new Field($field);

            $collection->put($field->handle, $field);
        }

        return $collection;
    }
}
