<?php

namespace Streams\Core\Field\Schema;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class HashSchema extends StrSchema
{
    public function type(): Schema
    {
        return Schema::string($this->type->field->handle)->format(Schema::FORMAT_PASSWORD);
    }
}
