<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Schema\BooleanSchema;
use Streams\Core\Field\Decorator\BooleanDecorator;

class BooleanFieldType extends Field
{
    public function cast($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOL);
    }

    public function modify($value)
    {
        return $this->cast($value);
    }

    public function restore($value)
    {
        return $this->cast($value);
    }

    public function default($value)
    {
        return $this->cast($value);
    }

    public function getSchemaName()
    {
        return BooleanSchema::class;
    }

    public function getDecoratorName()
    {
        return BooleanDecorator::class;
    }

    public function generator()
    {
        return function () {
            return fake()->randomElement([true, false]);
        };
    }
}
