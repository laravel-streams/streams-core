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
        return $this->cast($value);
    }

    public function expand($value): BooleanValue
    {
        return new BooleanValue($value);
    }

    public function schema()
    {
        $schema = Schema::boolean($this->field->handle);

        if ($default = $this->field->config('default')) {
            $schema = $schema->default($default);
        }

        $schema = $schema->nullable($this->field->hasRule('required'));
    }

    public function generate()
    {
        return $this->generator()->randomElement([true, false]);
    }
}
