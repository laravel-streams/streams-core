<?php

namespace Streams\Core\Schema\Types;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class UuidSchema extends StrSchema
{
    public function type(): Schema
    {
        return Schema::string($this->field->handle)->format(Schema::FORMAT_UUID);
    }
}
