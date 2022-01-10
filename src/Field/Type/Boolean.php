<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Field;
use Streams\Core\Field\Value\BooleanValue;
use Streams\Core\Field\Schema\BooleanSchema;

class Boolean extends Field
{
    public function cast($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOL);
    }

    public function modify($value)
    {
        return $this->cast($value);
    }

    public function getValueName()
    {
        return BooleanValue::class;
    }

    public function getSchemaName()
    {
        return BooleanSchema::class;
    }

    public function generate()
    {
        return $this->generator()->randomElement([true, false]);
    }
}
