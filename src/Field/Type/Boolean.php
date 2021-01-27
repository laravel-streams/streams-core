<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;

class Boolean extends FieldType
{
    /**
     * Modify the value for storage.
     *
     * @param string $value
     * @return bool
     */
    public function modify($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOL);
    }

    /**
     * Restore the value from storage.
     *
     * @param $value
     * @return bool
     */
    public function restore($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOL);
    }
}
