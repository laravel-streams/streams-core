<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Schema\StrSchema;
use Streams\Core\Field\Decorator\StringDecorator;

class StringFieldType extends Field
{
    public function cast($value)
    {
        return (string) $value;
    }

    public function modify($value)
    {
        return $this->cast($value);
    }

    public function restore($value)
    {
        return $this->cast($value);
    }

    public function generate()
    {
        return $this->generator()->text();
    }

    public function getDecoratorName()
    {
        return StringDecorator::class;
    }

    public function getSchemaName()
    {
        return StrSchema::class;
    }
}
