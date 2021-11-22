<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\ColorValue;

class Color extends FieldType
{
    public function cast($value)
    {
        return strtolower((string) $value);
    }

    public function modify($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return strtolower((string) $value);
    }

    public function expand($value)
    {
        return new ColorValue($value);
    }

    public function generate()
    {
        return '#' . str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
    }
}
