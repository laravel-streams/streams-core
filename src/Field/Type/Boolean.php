<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\BooleanValue;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class Boolean extends FieldType
{
    public function cast($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOL);
    }

    public function modify($value)
    {
        return $this->cast($value) ? 1 : 0;
    }

    public function expand($value): BooleanValue
    {
        return new BooleanValue($value);
    }

    public function schema()
    {
        return Schema::boolean($this->field->handle);
    }

    public function generate()
    {
        return $this->generator()->randomElement([true, false]);
    }
}
