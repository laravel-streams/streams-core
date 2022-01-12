<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Value\StrValue;
use Streams\Core\Field\Schema\StrSchema;

class StringFieldType extends Field
{

    public function modify($value)
    {
        return (string) $value;
    }

    public function restore($value)
    {
        return (string) $value;
    }

    public function generate()
    {
        return $this->generator()->text();
    }

    public function getValueName()
    {
        return StrValue::class;
    }

    public function getSchemaName()
    {
        return StrSchema::class;
    }
}
