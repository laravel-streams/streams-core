<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\StrValue;

class Str extends FieldType
{

    public function modify($value)
    {
        return (string) $value;
    }

    public function restore($value)
    {
        return (string) $value;
    }

    public function getValueName()
    {
        return StrValue::class;
    }

    public function generate()
    {
        return $this->generator()->text();
    }
}
