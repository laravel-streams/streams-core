<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\StrValue;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class Uuid extends FieldType
{

    public function default($value)
    {
        return $this->generate();
    }

    public function schema()
    {
        return Schema::string($this->field->handle)
            ->format(Schema::FORMAT_UUID);
    }

    public function generate()
    {
        return $this->generator()->uuid();
    }

    public function getValueName()
    {
        return StrValue::class;
    }
}
