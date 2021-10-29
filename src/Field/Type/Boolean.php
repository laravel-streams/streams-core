<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Factory\BooleanGenerator;
use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\BooleanValue;

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

    public function expand($value): BooleanValue
    {
        return new BooleanValue($value);
    }

    public function generator(): BooleanGenerator
    {
        return new BooleanGenerator($this);
    }
}
