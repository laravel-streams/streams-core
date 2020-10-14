<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\ArrValue;

/**
 * Class Arr
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Arr extends FieldType
{
    /**
     * The class attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Modify the value for storage.
     *
     * @param string $value
     * @return string
     */
    public function modify($value)
    {
        return json_encode($value);
    }

    /**
     * Restore the value from storage.
     *
     * @param $value
     * @return array
     */
    public function restore($value)
    {
        if (!is_string($value)) {
            return (array) $value;
        }

        return json_decode($value, true);
    }

    /**
     * Expand the value.
     *
     * @param $value
     * @return Collection
     */
    public function expand($value)
    {
        return new ArrValue($value);
    }
}
