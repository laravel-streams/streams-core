<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Field;
use Streams\Core\Field\Value\ColorValue;

class Color extends Field
{
    public function cast($value)
    {
        return strtolower((string) $value);
    }

    public function modify($value)
    {
        return $this->cast($value);
    }

    public function restore($value)
    {
        return $this->cast($value);
    }

    public function getValueName()
    {
        return ColorValue::class;
    }

    public function generate()
    {
        return '#' . str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
    }
}
