<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\StrValue;

class Str extends FieldType
{

    /**
     * Modify the value for storage.
     *
     * @param string $value
     * @return string
     */
    public function modify($value)
    {
        if (is_null($value)) {
            return $value;
        }
        
        return (string) $value;
    }

    /**
     * Restore the value from storage.
     *
     * @param $value
     * @return string
     */
    public function restore($value)
    {
        if (is_null($value)) {
            return $value;
        }
        
        return (string) $value;
    }

    public function expand($value)
    {
        return new StrValue($value);
    }
}
