<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\BooleanValue;

class Boolean extends FieldType
{
    public function cast($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return filter_var($value, FILTER_VALIDATE_BOOL);
    }

    public function restore($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return filter_var($value, FILTER_VALIDATE_BOOL);
    }

    public function expand($value): BooleanValue
    {
        return new BooleanValue($value);
    }

    public function generate()
    {
        return $this->generator()->randomElement([true, false]);
    }
}
