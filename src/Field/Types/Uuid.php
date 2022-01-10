<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Value\StrValue;
use Streams\Core\Field\Schema\UuidSchema;

class UuidFieldType extends Field
{

    public function default($value)
    {
        return $this->generate();
    }

    public function generate()
    {
        return $this->generator()->uuid();
    }

    public function getValueName()
    {
        return StrValue::class;
    }

    public function getSchemaName()
    {
        return UuidSchema::class;
    }
}
